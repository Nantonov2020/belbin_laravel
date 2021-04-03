<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Tests\TestCase;

class HRTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAllDepartmentsHR()
    {
        $user = $this->giveTestHR();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/company/'.($company->id));

        $response->assertSee('Организация');
    }

    private function giveTestHR()
    {
        return User::where('name','TestHR')->first();
    }

    private function giveTestCompany()
    {
        return Company::where('name','TestCompany')->first();
    }

    private function giveTestDepartment()
    {
        return Department::where('name','TestDepartment')->first();
    }

    private function giveTestUserForTestWorker()
    {
        return User::where('name','TestUser')->first();
    }

    public function testAllDepartmentsHRWithLoginNoHRFailed()
    {
        $user = $this->giveRandomUser();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/company/'.($company->id));

        $response->assertStatus(404);
    }

    private function giveRandomUser()
    {
        return User::factory()->create();
    }

    public function testOneDepartmentHR()
    {
        $user = $this->giveTestHR();
        $department = $this->giveTestDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/department/'.($department->id));

        $response->assertStatus(200);
    }

    public function testOneDepartmentHRWithLoginNotHRFailed()
    {
        $user = $this->giveRandomUser();
        $department = $this->giveTestDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/department/'.($department->id));

        $response->assertStatus(404);
    }

    public function testOneWorkerHR()
    {
        $user = $this->giveTestHR();
        $worker = $this->giveTestUserForTestWorker();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/worker/'.($worker->id));

        $response->assertStatus(200);
    }

    public function testOneWorkerHRWithLoginNotHRFailed()
    {
        $user = $this->giveRandomUser();
        $worker = $this->giveTestUserForTestWorker();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/worker/'.($worker->id));

        $response->assertStatus(404);
    }

    public function testAllWorkersHR()
    {
        $user = $this->giveTestHR();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/workers/'.($company->id));

        $response->assertStatus(200);
    }

    public function testAllWorkersHRWithLoginNoHRFailed()
    {
        $user = $this->giveRandomUser();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/workers/'.($company->id));

        $response->assertStatus(404);
    }

    public function testListHR()
    {
        $user = $this->giveTestHR();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/HRWorkers/'.($company->id));

        $response->assertStatus(200);
    }

    public function testListHRwithLoginNotHRFailed()
    {
        $user = $this->giveRandomUser();
        $company = $this->giveTestCompany();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/HRWorkers/'.($company->id));

        $response->assertStatus(404);
    }

    public function testShowResultsBelbinForOneWorker()
    {
        $user = $this->giveTestHR();
        $worker = $this->giveTestUserForTestWorker();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/showResultsBelbinForUser/'.($worker->id));

        $response->assertStatus(200);
    }

    public function testShowResultsBelbinForOneWorkerWithLoginNotHRFailed()
    {
        $user = $this->giveRandomUser();
        $worker = $this->giveTestUserForTestWorker();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/showResultsBelbinForUser/'.($worker->id));

        $response->assertStatus(404);
    }

    public function testShowResultsBelbinForOneDepartment()
    {
        $user = $this->giveTestHR();
        $department = $this->giveTestDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/showResultsBelbin/'.($department->id));

        $response->assertStatus(200);
    }

    public function testShowResultsBelbinForOneDepartmentWithLoginNotHRFailed()
    {
        $user = $this->giveRandomUser();
        $department = $this->giveTestDepartment();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('hr/showResultsBelbin/'.($department->id));

        $response->assertStatus(404);
    }

}
