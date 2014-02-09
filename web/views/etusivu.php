<?php
session_start();
resetTaskEdit();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';
$tasklist = task::getTasksSorted($_SESSION['userid']);
$taskId = (int) $_GET['taskId'];
?>
<?php require 'views/ylapalkki.php' ?>
<div>
    <div style="float:left">
        <h3>Askarelista</h3>
    </div>

    <div style="float:right">
        <br>
        <form action = "index.php" method = "get">
            Filtteröi listaa: <input type = "text" name = "filter" value = "<?php echo htmlspecialchars($_GET["filter"]) ?>"/>
            <button type = "submit">Filtteröi</button>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Askare</th>
                <th>Tärkeys</th>
                <th>Luokat</th>
                <th>Tehty</th>
                <th>Päivitä tila</th>
                <th>Poista</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($tasklist as $task) {
                ?>    <?php if ($task->filter(htmlspecialchars($_GET["filter"]) )) : ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><a href="index.php?taskId=<?php echo $task->getId() ?>&filter=<?php echo htmlspecialchars($_GET["filter"]) ?>"><?php echo $task->getName() ?></a></td>
                        <td><?php echo priority::getPriorityName($task->getPriority_id()) ?></td>
                        <td><?php
                            $tasktypes = tasktype::getTasktypes($task->getId());
                            foreach ($tasktypes as $type) {
                                echo $type . " ";
                            }
                            ?></td>
                        <td><?php
                            if ($task->getDone() === 0) {
                                echo "Ei";
                            } else {
                                echo "Kyllä";
                            }
                            ?></td>
                        <td><a href="rasite.php?donetoggle=<?php echo $task->getId() ?>" role="button" class="btn btn-xs btn-default"><?php
                            if ($task->getDone() === 0) {
                                echo "Merkitse tehdyksi";
                            } else {
                                echo "Merkitse tekemättömäksi";
                            }
                            $count++;
                            ?></a></td>
                        <td><a href="rasite.php?delete=<?php echo $task->getId() ?>" role="button" class="btn btn-xs btn-default">Poista</a></td>
                    </tr>
                <?php endif; ?>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($taskId > 0) : ?>
        <div class="subsection">
            <?php $active = task::getTask($taskId) ?>
            <h4><?php echo $active->getName() ?>, tärkeys:
                <?php echo priority::getPriorityName($active->getPriority_id()) ?>
                <h6>Luokat: <?php
                    $tasktypes = tasktype::getTasktypes($active->getId());
                    foreach ($tasktypes as $type) {
                        echo $type . " ";
                    }
                    ?></h6>
                <?php echo $active->getDescr() ?><br><br>
                <a href="askareenluonti.php?modify=1&id=<?php echo $active->getId() ?>" role="button" class="btn btn-xs btn-default">Muokkaa askaretta</a>
        </div>
    <?php endif; ?>

    <br>
    <div class="subsection">
        <a href="askareenluonti.php" role="button" class="btn btn-xs btn-default">Luo uusi askare</a>
        <a href="rasite.php?alldone=1" role="button" class="btn btn-xs btn-default">Merkitse kaikki tehdyksi</a>
        <a href="rasite.php?work=1" role="button" class="btn btn-xs btn-default">Merkitse kaikki tekemättömäksi</a>
    </div>
</div>


