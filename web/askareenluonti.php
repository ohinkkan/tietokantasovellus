<?php
require_once 'libs/utilities.php';
isLoggedIn();

resetTasktypeEdit();
resetPriorityEdit();

session_start();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';

# this controller is a mess. Had to start with the trickiest page. Perhaps I shall refactor it, someday.

$id = $_GET['id'];

if ($id > 0) {
    $_SESSION['modify'] = TRUE;
}

if (empty($_SESSION['taskdata']) OR $_GET['new']) {
    if ($_GET['new']) {
        unset($_SESSION['taskdata']);
        unset($_SESSION['modify']);
    }
    $_SESSION['taskdata'] = array(
        'modifytask' => $id,
        'name' => task::getTask($id)->getName(),
        'priority' => task::getTask($id)->getPriority_id(),
        'descr' => task::getTask($id)->getDescr(),
    );
}

$_SESSION['taskdata']['priorities'] = priority::getPrioritiesSorted($_SESSION['userid']);
$_SESSION['taskdata']['tasktypes'] = tasktype::getTasktypesSorted($_SESSION['userid']);

if (empty($_SESSION['taskdata']['priorities'])) {
    $_SESSION['virhe'] = "Ei yhtään tärkeysluokkaa tehtynä.";
    header('Location: index.php');
    exit();
}


if (empty($_SESSION['newtasktypes']) and empty($_SESSION['taskdata']['modifytasks'])) {
    $_SESSION['taskdata']['newtasktypes'] = array();
}

if (empty($_SESSION['taskdata']['modifytasks'])) {
    if ($id > 0) {
        $types = tasktype::getTypesForTask($id);
        foreach ($types as $type) {
            $_SESSION['taskdata']['newtasktypes'][$type->getId()] = $type->getId();
        }
    }
    $_SESSION['taskdata']['modifytasks'] = true;
}

if (isset($_GET['add'])) {
    $_SESSION['taskdata']['newtasktypes'][$_GET['add']] = $_GET['add'];
}
if (isset($_GET['remove'])) {
    unset($_SESSION['taskdata']['newtasktypes'][$_GET['remove']]);
}
if (isset($_GET['modify'])) {
    $_SESSION['modify'] = true;
}
?>

<script>
    function loadXMLDoc(var1)
    {
        var gets = "id=<?php echo $id ?>" + "&add=" + var1;
        window.location = "askareenluonti.php?" + gets;
    }
</script>

<?php
require 'views/ylapalkki.php';
displayView('views/luoaskare.php');
