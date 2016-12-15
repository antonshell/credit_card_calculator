<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div id="credit-calculator" class="well">
    <h1>Калькулятор кредитных карт</h1>
    <form action="" method="post" name="calc">

        <?php foreach($model->getErrors() as $error):?>
            <p><?= $error['message']?></p>
        <?php endforeach;?>

        <table class="table">
            <tr>
                <td>
                    <label>Процентная ставка</label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->rate; ?>" name="rate" maxlength="12" size="5" class="form-control">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Обязательный ежемесячный платёж</label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->monthRate; ?>" name="monthRate" maxlength="12" size="5" class="form-control">
                    </div>
                    % от задолженности(обычно 5-10%)
                </td>
            </tr>
            <tr>
                <td>
                    <label>Срок действия карты</label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->validity; ?>" name="validity" maxlength="12" size="5" class="form-control">
                    </div>
                    месяцев (обычно 36 месяцев, т.е. 3 года)
                </td>
            </tr>
            <tr>
                <td>
                    <label>Дата открытия карты:</label>
                </td>
                <td>
                    <?= $model->getStartDateHtml(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Сумма кредита</label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->totalCredit; ?>" name="totalCredit" maxlength="12" size="5" class="form-control">
                    </div>
                    рублей
                </td>
            </tr>
            <tr>
                <td>
                    <label>Комиссии в % от задолженности: </label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->monthCommissionPercent; ?>" name="monthCommissionPercent" maxlength="12" size="5" class="form-control">
                    </div>
                    % (за ведение счета, обслуживание)
                </td>
            </tr>
            <tr>
                <td>
                    <label>Комиссии ежемесячные фиксированные:</label>
                </td>
                <td>
                    <div class="col-lg-3">
                        <input type="text" value="<?= $model->monthCommissionFixed; ?>" name="monthCommissionFixed" maxlength="12" size="5" class="form-control" >
                    </div>
                    рублей в месяц
                </td>
            </tr>
        </table>

        <input type="hidden" value="calculation" name="form-type">

        <input type="submit" onclick="Validate2(0)" class="btn btn-default" value="Рассчитать">
    </form>
</div>

    <?php if($model->results):?>
        <div class="panel panel-default">
            <div class="panel-heading">Итого</div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-3">
                        Сумма кредита: <?= number_format((float)$model->totalCredit, 2, '.', '')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Сумма заплаченных всего: <?= number_format((float)$model->results['total'], 2, '.', '')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Сумма %: <?= number_format((float)$model->results['percent'], 2, '.', '')?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        Сумма комиссии: <?= number_format((float)$model->results['commissions'], 2, '.', '')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Переплата : <?= number_format((float)$model->results['overpayment'], 2, '.', '')?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

<?php if($model->payments):?>
<form action="" method="post" name="re-calc">
    <div class="well">

        <table class="table">
            <tr>
                <th>№</th>
                <th>Дата платежа</th>
                <th>Остаток долга</th>
                <th>Погашение основного долга</th>
                <th>Начисленные проценты</th>
                <th>Комиссии</th>
                <th>Сумма обязательного платежа</th>
                <th>Внесение средств на счет</th>
                <th>Снято со счета</th>
                <th></th>
            </tr>
            <?php //foreach($model->getPayments() as $i=>$payment):?>
            <?php foreach($model->payments as $i=>$payment):?>
            <tr>
                <td><?=$i?></td>
                <td><?=$months[(int)$payment['month']]." ".$payment['year'] ?></td>
                <td><?= number_format((float)$payment['debt'], 2, '.', '') ?></td>
                <td><?= number_format((float)$payment['mainDebtReturn'], 2, '.', '') ?></td>
                <td><?= number_format((float)$payment['percents'], 2, '.', '') ?></td>
                <td><?= number_format((float)$payment['commissions'], 2, '.', '') ?></td>
                <td><?= number_format((float)$payment['requiredPayment'], 2, '.', '') ?></td>
                <td>
                    <input class="form-control" type="text" value="<?= isset($model->moneyIn[$i]) ? number_format((float)$model->moneyIn[$i], 2, '.', '') : "" ?>" name="moneyIn[<?= $i?>]" maxlength="12" size="15" <?php echo ($i==0 ? 'disabled' : "")?> >
                </td>
                <td>
                    <input class="form-control" type="text" value="<?= isset($model->moneyOut[$i]) ? number_format((float)$model->moneyOut[$i], 2, '.', '') : "" ?>" name="moneyOut[<?= $i?>]" maxlength="12" size="15" <?php echo ($i==0 ? 'disabled' : "")?>>
                </td>
                <td>
                    <?php if($i):?>
                    <input type="submit" name="recalc-<?= $i ?>" class="btn btn-default" value="Пересчет">
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
            <input type="hidden" value="<?=$model->rate; ?>" name="rate">
            <input type="hidden" value="<?=$model->monthRate; ?>" name="monthRate">
            <input type="hidden" value="<?=$model->validity; ?>" name="validity">
            <input type="hidden" value="<?=$model->startMonth; ?>" name="startMonth">
            <input type="hidden" value="<?=$model->startYear; ?>" name="startYear">
            <input type="hidden" value="<?=$model->totalCredit; ?>" name="totalCredit">
            <input type="hidden" value="<?=$model->monthCommissionPercent; ?>" name="monthCommissionPercent">
            <input type="hidden" value="<?=$model->monthCommissionFixed; ?>" name="monthCommissionFixed">

            <input type="hidden" value="re-calculation" name="form-type">
    </div>



    <input type="submit" onclick="Validate2(0)" class="btn btn-default" value="Пересчет">
</form>
<?php endif;?>

</div>

</body>
</html>