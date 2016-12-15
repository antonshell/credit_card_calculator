<?php
require_once("CreditCardCalculator.php");

$model = new CreditCardCalculator();

if($_SERVER["REQUEST_METHOD"]=="POST"){

    if($_POST["form-type"]=="calculation"){
        $model->rate = $_POST["rate"];
        $model->monthRate = $_POST["monthRate"];
        $model->validity = $_POST["validity"];
        $model->startMonth = $_POST["startMonth"];
        $model->startYear = $_POST["startYear"];
        $model->totalCredit = $_POST["totalCredit"];
        $model->monthCommissionPercent = $_POST["monthCommissionPercent"];
        $model->monthCommissionFixed = $_POST["monthCommissionFixed"];

        if($model->validate()){
            $model->getPayments();
        }
    }

    if($_POST["form-type"]=="re-calculation"){
        $model->moneyIn = $_POST["moneyIn"];
        $model->moneyOut = $_POST["moneyOut"];

        $model->rate = $_POST["rate"];
        $model->monthRate = $_POST["monthRate"];
        $model->validity = $_POST["validity"];
        $model->startMonth = $_POST["startMonth"];
        $model->startYear = $_POST["startYear"];
        $model->totalCredit = $_POST["totalCredit"];
        $model->monthCommissionPercent = $_POST["monthCommissionPercent"];
        $model->monthCommissionFixed = $_POST["monthCommissionFixed"];

        for($i=1; $i<=$model->validity; $i++){
            if(isset($_POST['recalc-'.$i])){
                $model->recalc = $i;
                break;
            }
        }

        if($model->validate()){
            $model->getPayments();
        }
    }

$months = $model->getMonths();
}

require_once("form.php");