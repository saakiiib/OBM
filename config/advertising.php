<?php
return [
 'preview'=>env('OBM_AD_PREVIEW',false),
 'publisher'=>env('OBM_ADSENSE_PUBLISHER',''),
 'slots'=>['home_top'=>env('OBM_AD_HOME_TOP',''),'home_bottom'=>env('OBM_AD_HOME_BOTTOM',''),'category_bottom'=>env('OBM_AD_CATEGORY_BOTTOM',''),'directory_bottom'=>env('OBM_AD_DIRECTORY_BOTTOM','')],
 'products'=>[
 ['name'=>'HouseholdOS','label'=>'Family organisation','description'=>'Manage household tasks and renewals in one place.','url'=>env('OBM_HOUSEHOLD_URL','https://householdosapp.com/'),'initials'=>'H'],
 ['name'=>'MentoClock','label'=>'Business attendance','description'=>'Staff clock-in and clock-out, attendance and reporting.','url'=>env('OBM_CLOCK_URL','https://mentoclock.com/'),'initials'=>'MC'],
 ['name'=>'MentoAcc','label'=>'Accounting software','description'=>'Explore accounting software from Mento Software.','url'=>env('OBM_ACCOUNTING_URL','https://mentoac.co.uk/'),'initials'=>'MA'],
 ],
];
