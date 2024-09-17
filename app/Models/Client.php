<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FamilyMember;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'control_number',
        'first_name',
        'last_name',
        'middle',
        'suffix',
        'building_number',
        'street_name',
        'barangay',
        'age',
        'date_of_birth',
        'pob',
        'sex',
        'educational_attainment',
        'civil_status',
        'religion',
        'nationality',
        'occupation',
        'monthly_income',
        'contact_number',
        'source_of_referral',
        'circumstances_of_referral',
        'family_background',
        'health_history',
        'economic_situation',
        'house_structure',
        'floor',
        'type',
        'number_of_rooms',
        'appliances',
        'other_appliances',
        'monthly_expenses',
        'indicate',
        'assessment',
        'recommendation',
        'tracking',
        'received',
        'forbudget',
        'forreview',
        'forsignature',
        'disbursement',
        'problem_identification',
        'data_gather',
        'eval',
        'control_number',
        'problem_presented',
        'services',
        'requirements',
        'home_visit',
        'interviewee',
        'interviewed_by',
        'layunin',
        'resulta',
        'initial_findings',
        'initial_agreement',
        'assessment1',
        'case_management_evaluation',
        'case_resolution',
        'reviewing',
        'approving',

    ];

    public function setCaseManagementEvaluationAttribute($value)
    {
        $this->attributes['case_management_evaluation'] = ucwords($value);
    }
    public function setCaseResolutionAttribute($value)
    {
        $this->attributes['case_resolution'] = ucwords($value);
    }
    public function setReviewingAttribute($value)
    {
        $this->attributes['reviewing'] = ucwords($value);
    }
    public function setApprovingAttribute($value)
    {
        $this->attributes['approving'] = ucwords($value);
    }
    public function setAssessment1Attribute($value)
    {
        $this->attributes['assessment1'] = ucwords($value);
    }
    public function setLayuninAttribute($value)
    {
        $this->attributes['layunin'] = ucwords($value);
    }
    public function setResultaAttribute($value)
    {
        $this->attributes['resulta'] = ucwords($value);
    }
    public function setInitialFindingsAttribute($value)
    {
        $this->attributes['initial_findings'] = ucwords($value);
    }
    public function setInitialAgreementAttribute($value)
    {
        $this->attributes['initial_agreement'] = ucwords($value);
    }
    public function setIntervieweeAttribute($value)
    {
        $this->attributes['interviewee'] = ucwords($value);
    }
    public function setInterviewedByAttribute($value)
    {
        $this->attributes['interviewed_by'] = ucwords($value);
    }
    public function setProblemPresentedAttribute($value)
    {
        $this->attributes['problem_presented'] = ucwords($value);
    }
    public function setServicesAttribute($value)
    {
        if (is_array($value)) {
            // Handle the array case: convert it to a string or handle it as needed
            $value = implode(', ', $value); // Convert array to a comma-separated string
        }

        // Now $value should be a string
        $this->attributes['services'] = ucwords($value);
    }

    public function setTrackingAttribute($value)
    {
        $this->attributes['tracking'] = ucwords($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords($value);
    }

    public function setMiddleAttribute($value)
    {
        $this->attributes['middle'] = ucwords($value);
    }

    public function setSuffixAttribute($value)
    {
        $this->attributes['suffix'] = ucwords($value);
    }

    public function setbuildingNumberAttribute($value)
    {
        $this->attributes['building_number'] = ucwords($value);
    }
    public function setstreetNameAttribute($value)
    {
        $this->attributes['street_name'] = ucwords($value);
    }
    public function setbarangayAttribute($value)
    {
        $this->attributes['barangay'] = ucwords($value);
    }

    public function setPobAttribute($value)
    {
        $this->attributes['pob'] = ucwords($value);
    }

    public function setEducationalAttainmentAttribute($value)
    {
        $this->attributes['educational_attainment'] = ucwords($value);
    }

    public function setReligionAttribute($value)
    {
        $this->attributes['religion'] = ucwords($value);
    }



    public function setNationalityAttribute($value)
    {
        $this->attributes['nationality'] = ucwords($value);
    }



    public function setOccupationAttribute($value)
    {
        $this->attributes['occupation'] = ucwords($value);
    }

    public function setMonthlyIncomeAttribute($value)
    {
        $this->attributes['monthly_income'] = ucwords($value);
    }

    public function setSourceOfReferralAttribute($value)
    {
        $this->attributes['source_of_referral'] = ucwords($value);
    }
    public function setCircumstancesOfReferralAttribute($value)
    {
        $this->attributes['circumstances_of_referral'] = ucwords($value);
    }

    public function setFamilyBackgroundAttribute($value)
    {
        $this->attributes['family_background'] = ucwords($value);
    }

    public function setHealthHistoryAttribute($value)
    {
        $this->attributes['health_history'] = ucwords($value);
    }

    public function setEconomicSituationAttribute($value)
    {
        $this->attributes['economic_situation'] = ucwords($value);
    }

    public function setHouseStructureAttribute($value)
    {
        $this->attributes['house_structure'] = ucwords($value);
    }

    public function setFloorAttribute($value)
    {
        $this->attributes['floor'] = ucwords($value);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = ucwords($value);
    }

    public function setNumberOfRoomsAttribute($value)
    {
        $this->attributes['number_of_rooms'] = ucwords($value);
    }

    public function setAppliancesAttribute($value)
    {
        if (is_array($value)) {
            $value = array_map('ucwords', $value); // Apply ucwords to each element
        } else {
            $value = ucwords($value); // Apply ucwords to the string
        }
        $this->attributes['appliances'] = $value;
    }


    public function setOtherAppliancesAttribute($value)
    {
        $this->attributes['other_appliances'] = ucwords($value);
    }

    public function setMonthlyExpensesAttribute($value)
    {
        $this->attributes['monthly_expenses'] = ucwords($value);
    }

    public function setIndicateAttribute($value)
    {
        $this->attributes['indicate'] = ucwords($value);
    }

    public function setAssessmentAttribute($value)
    {
        $this->attributes['assessment'] = ucwords($value);
    }

    public function setRecommendationAttribute($value)
    {
        $this->attributes['recommendation'] = ucwords($value);
    }
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'client_id');
    }
}
