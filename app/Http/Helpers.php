<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Helpers {

    public static function getBranch(){
        $b = DB::table('employees')->selectRaw('branches.id, branches.alias, departements.name, marketing_groups.id AS marketingId, marketing_groups.name AS marketingName')
            ->join('sub_branches', 'sub_branches.id', 'employees.sub_branch_id')
            ->join('branches', 'branches.id', 'sub_branches.branch_id')
            ->join('departements', 'departements.id', 'employees.departement_id')
            ->leftjoin('marketing_groups', 'marketing_groups.employee_id', 'employees.id')
            ->where('employees.id', Auth::user()->employee_id)
            ->get();

        return $b[0];
    }
}
