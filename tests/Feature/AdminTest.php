<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{

    public function testLoginAdmin()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
                        ->withSession(['banned' => false])
                        ->get('/home');

        $response->assertStatus(200);
    }

    private function initUser()
    {
        $user = User::factory()->create();
        $user->is_admin = true;
        $user->secondName = 'SecondName';

        return $user;
    }

    public function testAdminCompanies()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/admin');

        $response->assertStatus(200);
    }

    public function testAdminCompaniesNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/admin');

        $response->assertStatus(404);
    }

    private function getUserNoAdmin()
    {
        $user = $this->initUser();
        $user->is_admin = false;

        return $user;
    }

    public function testAdminDepartments()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/departments');

        $response->assertStatus(200);
    }

    public function testAdminDepartmentsNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/departments');

        $response->assertStatus(404);
    }

    public function testAdminUsers()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/users');

        $response->assertStatus(200);
    }

    public function testAdminUsersNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/users');

        $response->assertStatus(404);
    }

    public function testAdminHR()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/HRworkers');

        $response->assertStatus(200);
    }

    public function testAdminHRNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/HRworkers');

        $response->assertStatus(404);
    }

    public function testAdminOneCompany()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/company/2');

        $response->assertStatus(200);
    }

    public function testAdminOneCompanyNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/company/2');

        $response->assertStatus(404);
    }

    public function testAdminOneCompanyFailed()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/company/0');

        $response->assertSee('Организация не найдена.');
    }

    public function testAdminOneDepartment()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/department/3');

        $response->assertStatus(200);
    }

    public function testAdminOneDepartmentNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/department/3');

        $response->assertStatus(404);
    }

    public function testAdminOneDepartmentFailed()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/department/0');

        $response->assertStatus(404);
    }

    public function testAdminOneUser()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/user/1552');

        $response->assertStatus(200);
    }

    public function testAdminOneUserNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/user/1552');

        $response->assertStatus(404);
    }

    public function testAdminOneUserFailed()
    {
        $user = $this->initUser();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/user/0');

        $response->assertStatus(404);
    }

}
