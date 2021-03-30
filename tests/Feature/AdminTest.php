<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
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

        $response->assertSee('Компании');
    }

    private function initUser()
    {
        $user = User::factory()->create();
        $user->is_admin = true;
        $user->secondName = 'SecondName';

        return $user;
    }

    public function testLoginNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/home');

        $response->assertDontSee('Компании');
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
        $idRandomCompany = $this->giveNumberRandomAvailableCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/company/$idRandomCompany");

        $response->assertStatus(200);
    }

    private function giveNumberRandomAvailableCompany():int
    {
        $company = Company::inRandomOrder()->first();
        return $company->id;
    }

    public function testAdminOneCompanyNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();
        $idRandomCompany = $this->giveNumberRandomAvailableCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/company/$idRandomCompany");

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
        $idRandomDepartment = $this->giveRandomNumberAvailableDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/department/$idRandomDepartment");

        $response->assertStatus(200);
    }

    private function giveRandomNumberAvailableDepartment():int
    {
        $department = Department::inRandomOrder()->first();

        return $department->id;
    }

    public function testAdminOneDepartmentNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();
        $idRandomDepartment = $this->giveRandomNumberAvailableDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/department/$idRandomDepartment");

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
        $idRandomUserFromDB = $this->giveNumberRandomAvailableUserFromDB();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/user/$idRandomUserFromDB");

        $response->assertStatus(200);
    }

    private function giveNumberRandomAvailableUserFromDB():int
    {
        $userFromDB = User::inRandomOrder()->first();

        return $userFromDB->id;
    }

    public function testAdminOneUserNoAdminFailed()
    {
        $user = $this->getUserNoAdmin();
        $idRandomUserFromDB = $this->giveNumberRandomAvailableUserFromDB();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get("/user/$idRandomUserFromDB");

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
