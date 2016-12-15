<?php
class CreditCardCalculator{
    public $rate=24;
    public $monthRate=5;
    public $validity=36;
    public $startMonth=01;
    public $startYear=2014;
    public $totalCredit=10000;
    public $monthCommissionPercent=0;
    public $monthCommissionFixed=300;

    public $payments = array();
    public $results = array();

    public $moneyIn = array();
    public $moneyOut = array();

    public $recalc = 0;

    public $errors = array();

    public function addError($error){
        $this->errors[] = $error;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function validate(){
        $this->errors = array();

        //return true;

        if(!is_numeric($this->rate) || $this->rate<0 || $this->rate>100){
            $error = array(
                'message' => 'Неправильная процентная ставка',
                'attribute' => 'rate'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->monthRate) || $this->monthRate<0 || $this->monthRate>100){
            $error = array(
                'message' => 'Неправильный ежемесячный платёж',
                'attribute' => 'monthRate'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->validity) || $this->validity<0 || $this->validity>60){
            $error = array(
                'message' => 'Неправильный срок действия карты',
                'attribute' => 'validity'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->startMonth) || $this->startMonth<1 || $this->startMonth>12){
            $error = array(
                'message' => 'Неправильный месяц',
                'attribute' => 'startMonth'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->startYear) || $this->startYear<date("Y")-6 || $this->startYear>date("Y")+6){
            $error = array(
                'message' => 'Неправильный год',
                'attribute' => 'startYear'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->totalCredit) || $this->totalCredit<0){
            $error = array(
                'message' => 'Неправильная сумма кредита',
                'attribute' => 'totalCredit'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->monthCommissionPercent) || $this->monthCommissionPercent<0 || $this->monthCommissionPercent>100){
            $error = array(
                'message' => 'Неправильная Комиссия',
                'attribute' => 'monthCommissionPercent'
            );
            $this->addError($error);
        }
        if(!is_numeric($this->monthCommissionFixed) || $this->monthCommissionFixed<0 || $this->monthCommissionFixed>3000){
            $error = array(
                'message' => 'Неправильная Комиссия',
                'attribute' => 'monthCommissionFixed'
            );
            $this->addError($error);
        }

        if($this->errors)
            return false;
        return true;

    }

    public function getPayments(){
        $payments = array();

        $year = $this->startYear;
        $month = (int)$this->startMonth;
        $debt = $this->totalCredit;

        //1й месяц - все равно 0
        $payments[0]['year'] = $year;
        $payments[0]['month'] = $month;
        $payments[0]['debt'] = 0;
        $payments[0]['mainDebtReturn'] = 0;
        $payments[0]['percents'] = 0;
        $payments[0]['commissions'] = 0;
        $payments[0]['requiredPayment'] = 0;

        $this->moneyOut[0] = $this->totalCredit;

        if($month == 12){
            $year++;
            $month = 1;
        }
        else{
            $month++;
        }
        ////

        for($i=1; $i<=$this->validity; $i++){
            $payments[$i]['year'] = $year;
            $payments[$i]['month'] = $month;
            $payments[$i]['debt'] = $debt;


            if($i==$this->validity){
                $payments[$i]['mainDebtReturn'] = $debt;
            }
            else{
                $payments[$i]['mainDebtReturn'] = $debt*$this->monthRate/100;
            }

            $payments[$i]['percents'] = $this->rate/(12*100)*$debt;
            $payments[$i]['commissions'] = $debt*$this->monthCommissionPercent/100 + $this->monthCommissionFixed;
            $payments[$i]['requiredPayment'] = $payments[$i]['mainDebtReturn'] + $payments[$i]['percents'] + $payments[$i]['commissions'];

            if(!isset($this->moneyIn[$i]) || $this->moneyIn[$i]==="" || $i>$this->recalc){
                $this->moneyIn[$i] = $payments[$i]['requiredPayment'];
            }

            $debt -= $payments[$i]['mainDebtReturn'];

            if(isset($this->moneyIn[$i]) && isset($this->moneyOut[$i])){
                $moneyIn = $this->moneyIn[$i];
                $moneyOut = $this->moneyOut[$i];

                if($moneyIn===""){
                    $moneyIn = $payments[$i]['requiredPayment'];
                }

                if($moneyOut===""){
                    $moneyOut = 0;
                }

                $debt += $payments[$i]['requiredPayment'] - ($moneyIn - $moneyOut);
            }


            //увеличиваем месяц. если декабрь - увеличиваем год
            if($month == 12){
                $year++;
                $month = 1;
            }
            else{
                $month++;
            }
        }

        //return $payments;
        $this->payments = $payments;
        $this->getResults();
    }

    public function getResults(){
        if(!$this->payments)
            return false;

        $results = array(
            'total'=>0,
            'debt'=>0,
            'percent'=>0,
            'commissions'=>0,
            'overpayment'=>0
        );

        foreach($this->payments as $payment){
            $results['total'] += $payment['requiredPayment'];
            $results['debt'] += $payment['mainDebtReturn'];
            $results['percent'] += $payment['percents'];
            $results['commissions'] += $payment['commissions'];
        }

        //$results['overpayment'] += ($results['total'] - $this->totalCredit)/$this->totalCredit;
        $results['overpayment'] += ($results['total'] - $this->totalCredit);

        $this->results = $results;
    }

    /*
     * получаем месяцы
     */
    public function getMonths(){
        return array(
            '1' => 'Январь',
            '2' => 'Февраль',
            '3' => 'Март',
            '4' => 'Апрель',
            '5' => 'Май',
            '6' => 'Июнь',
            '7' => 'Июль',
            '8' => 'Август',
            '9' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        );
    }

    public function getStartDateHtml(){
        $months = $this->getMonths();

        $html = "";


        $html .= '<div class="col-lg-3">';
        $html .= '<select name="startMonth" id="startMonth" class="form-control" >';

        foreach($months as $k=>$v){
            //if($this->startMonth == $k){
            if((int)$this->startMonth == $k){
                $html .= '<option value="'.$k.'" selected>'.$v.'</option>';
            }
            else{
                $html .= '<option value="'.$k.'">'.$v.'</option>';
            }
        }

        $html .= '</select>';

        $html .= '</div>';
        //$currentYear = 2014;
        $currentYear = date("Y");

        $html .= '<div class="col-lg-3">';

        $html .= '<select name="startYear" id="startYear" class="form-control">';

        for($i = $currentYear-6; $i<=$currentYear+6; $i++){
            $html .= '<option value="'.$i.'">'.$i.'</option>';

            if($this->startYear == $i){
                $html .= '<option value="'.$i.'" selected>'.$i.'</option>';
            }
            else{
                $html .= '<option value="'.$i.'">'.$i.'</option>';
            }
        }
        $html .= '</select>';

        $html .= '</div>';

        return $html;
    }
}