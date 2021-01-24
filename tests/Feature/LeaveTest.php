<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// use App\Leave;

class LeaveTest extends TestCase
{
    
    /** @test */
    public function hasValidFactoryTest()
    {
        $leave =  factory(\App\Leave::class)->make();
        $this->assertTrue($leave->applied_by === 6);
        $this->assertTrue($leave->leave_types_id === 1);
        $this->assertTrue($leave->no_of_days === 1);
        $sick_leave = factory(\App\Leave::class)->states('sick_leave')->make();
        $this->assertTrue($sick_leave->leave_types_id === 2);
    }
}
