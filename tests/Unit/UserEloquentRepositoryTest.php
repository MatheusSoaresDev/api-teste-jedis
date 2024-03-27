<?php

namespace Tests\Unit;

use App\Models\Produto;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepositoryInterface::class);
    }

    public function test_find_all_users()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->userRepository->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'role' => $role->role,
        ]);

        $users = $this->userRepository->findAll();
        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(2, $users);
    }

    public function test_create_user()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_update_user()
    {
        $userRole = new Role([
            'role' => 'user',
        ]);
        $userRole->save();

        $adminRole = new Role([
            'role' => 'admin',
        ]);
        $adminRole->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $userRole->role,
        ]);

        $data = [
            'name' => 'Jane Doe',
            'email' => '',
            'password' => bcrypt('changepassword'),
            'role' => $adminRole->role,
        ];

        $user = $this->userRepository->update($user->id, $data);

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['password'], $user->password);
        $this->assertEquals($data['role'], $user->role);
    }

    public function test_delete_user()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->userRepository->delete($user->id);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_find_user_by_id()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $foundUser = $this->userRepository->findById($user->id);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->name, $foundUser->name);
    }

    public function test_find_user_by_id_not_found()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->userRepository->findById(1);
    }

    public function test_promote_user_to_admin()
    {
        $userRole = new Role([
            'role' => 'user',
        ]);
        $userRole->save();

        $adminRole = new Role([
            'role' => 'admin',
        ]);
        $adminRole->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $userRole->role,
        ]);

        $this->userRepository->promoteToAdmin($user->id);
        $this->assertDatabaseHas('users', ['role' => 'admin']);
    }

    public function test_get_user_with_role_by_email()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $foundUser = $this->userRepository->getUserWithRoleByEmail($user->email);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->name, $foundUser->name);
    }

    public function test_realiza_compra()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->actingAs($user);

        $produto = new Produto([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do Produto Exemplo',
            'preco' => 100.00,
            'quantidade' => 10,
        ]);
        $produto->save();

        $user = $this->userRepository->realizaCompra($produto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertDatabaseHas('compra', ['user_id' => $user->id, 'produto_id' => $produto->id]);
    }

    public function test_lista_compras()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->actingAs($user);

        $produto = new Produto([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do Produto Exemplo',
            'preco' => 100.00,
            'quantidade' => 10,
        ]);

        $produto->save();

        $this->userRepository->realizaCompra($produto);
        $comprasRealizadas = $this->userRepository->listaCompras();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertDatabaseHas('compra', ['user_id' => $user->id, 'produto_id' => $produto->id]);
        $this->assertIsArray($comprasRealizadas);
    }

    public function test_lista_compra()
    {
        $role = new Role([
            'role' => 'user',
        ]);
        $role->save();

        $user = $this->userRepository->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => $role->role,
        ]);

        $this->actingAs($user);

        $produto = new Produto([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do Produto Exemplo',
            'preco' => 100.00,
            'quantidade' => 10,
        ]);

        $produto->save();

        $this->userRepository->realizaCompra($produto);
        $compraRealizada = $this->userRepository->listaCompra($produto->id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertDatabaseHas('compra', ['user_id' => $user->id, 'produto_id' => $produto->id]);
        $this->assertIsArray($compraRealizada);
    }

    public function test_if_entity_is_user()
    {
        $this->assertInstanceOf(User::class, new($this->userRepository->entity()));
    }
}
