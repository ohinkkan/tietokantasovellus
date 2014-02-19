<div>
    <div style="float:left">
        <h3>Askarelista</h3>
    </div>

    <div style="float:right">
        <br>
        <form action = "index.php" method = "get">
            Filtteröi listaa: <input type = "text" name = "filter" value = "<?php echo $data->filter ?>"/>
            <button type = "submit">Filtteröi</button>
        </form>
    </div>
    <div style = "clear:both">
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
                foreach ($data->tasklist as $task) {
                    ?>    <?php if ($task->filter($data->filter)) : ?>
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
    </div>
    <?php if ($data->taskId > 0) : ?>
        <div class="subsection">
            <h4><?php echo $data->active->getName() ?>, tärkeys:
                <?php echo priority::getPriorityName($data->active->getPriority_id()) ?>
                <h6>Luokat: <?php
                    foreach ($data->activetasktypes as $type) {
                        echo $type . " ";
                    }
                    ?></h6>
                <?php echo $data->active->getDescr() ?><br><br>
                <a href="askareenluonti.php?modify=1&id=<?php echo $data->active->getId() ?>" role="button" class="btn btn-xs btn-default">Muokkaa askaretta</a>
        </div>
    <?php endif; ?>

    <br>
    <div class="subsection">
        <a href="askareenluonti.php" role="button" class="btn btn-xs btn-default">Luo uusi askare</a>
        <a href="rasite.php?alldone=1" role="button" class="btn btn-xs btn-default">Merkitse kaikki tehdyksi</a>
        <a href="rasite.php?work=1" role="button" class="btn btn-xs btn-default">Merkitse kaikki tekemättömäksi</a>
    </div>
</div>


