<?php
session_start();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';



$_SESSION['modifytask'] = (int) $_GET['id'];
$id = $_SESSION['modifytask'];

if (isset($data->name)) {
    $newname = $data->name;
} else {
    $newname = task::getTask($id)->getName();
}
if (isset($data->priority)) {
    $newpriority = $data->priority;
} else {
    $newpriority = task::getTask($id)->getPriority_id();
}
if (isset($data->descr)) {
    $newdescr = $data->descr;
} else {
    $newdescr = task::getTask($id)->getDescr();
}

if (empty($_SESSION['newtasktypes']) and empty($_SESSION['modifytasks'])) {
    $_SESSION['newtasktypes'] = array();
}

if (empty($_SESSION['modifytasks'])) {
    if ($id > 0) {
        $types = tasktype::getTypesForTask($id);
        foreach ($types as $type) {
            $_SESSION['newtasktypes'][$type->getId()] = $type->getId();
        }
    }
    $_SESSION['modifytasks'] = true;
}
if (isset($_GET['add'])) {
    $add = (int) $_GET['add'];
    $_SESSION['newtasktypes'][$add] = $add;
}
if (isset($_GET['remove'])) {
    unset($_SESSION['newtasktypes'][$_GET['remove']]);
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

<?php require 'views/ylapalkki.php' ?>
<div>
    <div>
        <h3>Askareen <?php
            if ($_SESSION['modify']) {
                echo muokkaus;
            } else {
                echo luonti;
            }
            ?> - muuta luokkia ensimmäiseksi, koska <b>ajax + sessions = fail</b>, voi ajan haaskausta -_-</h3>
    </div>
    <form action = "askaretarkistus.php" method = "POST">
        <div class="subsection">
            Nimi: <input type="text" value="<?php echo $newname ?>" name = "name">
            Tärkeys:
            <select class="btn btn-default btn-xs" name = "priority">
                <?php
                $priorities = priority::getPrioritiesSorted($_SESSION['userid']);
                foreach ($priorities as $priority) {
                    ?>
                    <option value="<?php echo $priority->getId() ?>"<?php
                    if ($priority->getId() === $newpriority) {
                        echo "selected";
                    }
                    ?>><?php echo $priority->getName() ?></option>
                        <?php } ?>
            </select>
            <h4>Kuvaus:</h4>
            <textarea rows="4" style="width:100%" name = "descr"><?php echo $newdescr ?></textarea>
            <br>
            <br>  <div class="btn-group">
                Lisää luokka:
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    Valitse luokka <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php
                    $tasktypes = tasktype::getTasktypesSorted($_SESSION['userid']);
                    foreach ($tasktypes as $type) {
                        ?>
                        <li><a href="#" id="<?php echo $type->getId() ?>" ><?php echo $type->getName() ?></a></li>
                        <script>
                            $("#<?php echo $type->getId() ?>").click(function(e) {
                                loadXMLDoc(<?php echo $type->getId() ?>);
                                e.preventDefault();
                            });
                        </script>
                    <?php } ?>
                </ul>
            </div>
            <div id ="typeselect">
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Luokka</th>
                            <th>Poista</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($_SESSION['newtasktypes'] as $typeid) {
                            ?>
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo tasktype::getTasktypeName($typeid) ?></td>
                                <td><a href="askareenluonti.php?id=<?php echo $id ?>&remove=<?php echo $typeid ?>" role="button" class="btn btn-xs btn-default">Poista</a></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>
            <button type="submit" class="btn btn-xs btn-default">Tallenna</button>
        </div>
    </form>
</div>

