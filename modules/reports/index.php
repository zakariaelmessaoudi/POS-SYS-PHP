<?php
require_once dirname(__DIR__,2).'/core/bootstrap.php';
Auth::requireAdmin();
$db=Database::getInstance()->pdo();
$from=isset($_GET['from'])?$_GET['from']:date('Y-m-01');
$to=isset($_GET['to'])?$_GET['to']:date('Y-m-d');
$st=$db->prepare('SELECT COUNT(*) invoices,COALESCE(SUM(total),0) revenue,COALESCE(SUM(discount),0) discounts FROM sales WHERE DATE(created_at) BETWEEN ? AND ?');
$st->execute(array($from,$to));$sales=$st->fetch();
$st=$db->prepare('SELECT COALESCE(SUM(si.quantity*si.unit_cost),0) cogs FROM sale_items si JOIN sales s ON s.id=si.sale_id WHERE DATE(s.created_at) BETWEEN ? AND ?');
$st->execute(array($from,$to));$cogs=(float)$st->fetchColumn();
$st=$db->prepare('SELECT COALESCE(SUM(amount),0) FROM expenses WHERE expense_date BETWEEN ? AND ?');
$st->execute(array($from,$to));$expenses=(float)$st->fetchColumn();
$gross=(float)$sales['revenue']-$cogs;$net=$gross-$expenses;
if(isset($_GET['export'])){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="cafe-report.csv"');
    echo "\xEF\xBB\xBF";echo "البند,القيمة\n";
    echo 'الإيرادات,'.number_format($sales['revenue'],2)."\n";
    echo 'تكلفة البضاعة,'.number_format($cogs,2)."\n";
    echo 'الربح الإجمالي,'.number_format($gross,2)."\n";
    echo 'المصاريف,'.number_format($expenses,2)."\n";
    echo 'صافي الربح,'.number_format($net,2)."\n";exit;
}
$pageTitle='التقارير المالية';require APP_ROOT.'/includes/header.php';
?>
<div class="page-heading"><div><h1>التقارير المالية</h1><p>ملخص الأرباح والخسائر حسب الفترة</p></div><a class="btn btn-outline-secondary" href="?from=<?= Helper::e($from) ?>&to=<?= Helper::e($to) ?>&export=csv">تصدير CSV</a></div>
<form class="card card-body mb-3" method="get"><div class="row g-2 align-items-end"><div class="col-auto"><label>من</label><input type="date" class="form-control" name="from" value="<?= Helper::e($from) ?>"></div><div class="col-auto"><label>إلى</label><input type="date" class="form-control" name="to" value="<?= Helper::e($to) ?>"></div><div class="col-auto"><button class="btn btn-coffee">تحديث التقرير</button></div></div></form>
<div class="row g-3"><div class="col-md-6 col-xl-3"><div class="stat-card"><div class="label">الإيرادات</div><div class="value"><?= Helper::money($sales['revenue']) ?></div></div></div><div class="col-md-6 col-xl-3"><div class="stat-card"><div class="label">تكلفة البضاعة المباعة</div><div class="value"><?= Helper::money($cogs) ?></div></div></div><div class="col-md-6 col-xl-3"><div class="stat-card"><div class="label">الربح الإجمالي</div><div class="value"><?= Helper::money($gross) ?></div></div></div><div class="col-md-6 col-xl-3"><div class="stat-card"><div class="label">المصاريف</div><div class="value"><?= Helper::money($expenses) ?></div></div></div><div class="col-12"><div class="card card-body d-flex flex-row justify-content-between align-items-center"><div><span class="muted">صافي الربح · عدد الفواتير <?= (int)$sales['invoices'] ?></span><div class="fs-3 fw-bold <?= $net<0?'text-danger':'text-success' ?>"><?= Helper::money($net) ?></div></div><i class="bi bi-graph-up-arrow fs-1 text-success"></i></div></div></div>
<?php require APP_ROOT.'/includes/footer.php';
