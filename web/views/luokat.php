<div>
    <div style="float:left">
        <h3>Askareluokat</h3>
    </div>

    <div style="float:right">
        <br>
        <form action = "askareluokat.php" method = "get">
            Filtteröi listaa: <input type = "text" name = "filter" value = "<?php echo $_SESSION['tasktypedata']['filter'] ?>"/>
            <input type ="hidden" name ="typeid" value="<?php $_SESSION['tasktypedata']['active'] ?>">
            <button type = "submit">Filtteröi</button>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nimi</th>
                <th>Yläluokka</th>
                <th>Poista</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($_SESSION['tasktypedata']['tasktypes'] as $tasktype) {
                ?>
                <?php if ($tasktype->filter($_SESSION['tasktypedata']['filter'])) { ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><a href="askareluokat.php?typeid=<?php echo $tasktype->getId() ?>&filter=<?php echo htmlspecialchars($_GET["filter"]) ?>"><?php echo $tasktype->getName() ?></a></td>
                        <td>
                            <?php
                            if (($tasktype->getUpper_id()) < 1) {
                                echo "Ei mikään";
                            } else {
                                echo tasktype::getTasktypeName($tasktype->getUpper_id());
                            }
                            $count++;
                            ?>
                        <td><a href="askareluokat.php?remove=<?php echo $tasktype->getId() ?>" role="button" class="btn btn-xs btn-default">Poista</a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <div class="subsection">
        <form action = "luokkatarkistus.php" method = "POST">
            <?php if ($_SESSION['modify']) { ?>
                <h4>Muokkaa askareluokkaa</h4>
            <?php } else { ?>
                <h4>Luo uusi askareluokka</h4>
            <?php } ?>
            Nimi: <input type="text" value="<?php echo $_SESSION['tasktypedata']['name'] ?>" name = "name">
            Yläluokka:
            <select class="btn btn-default btn-xs" name = "upper">
                <option value="0">Ei mikään</option>
                <?php
                foreach ($_SESSION['tasktypedata']['tasktypes'] as $current) {
                    ?>
                    <?php if ($_SESSION['tasktypedata']['active'] != $current->getId()) { ?>
                        <option value="<?php echo $current->getId() ?>"<?php
                        if ($current->getId() === $_SESSION['tasktypedata']['upper']) {
                            echo "selected";
                        }
                        ?>>
                            <?php echo $current->getName() ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <br>
            <br>
            <button type="submit" class="btn btn-xs btn-default">Tallenna</button>
            <?php if ($_SESSION['modify']) { ?>
                <a href="askareluokat.php?new=true" role="button" class="btn btn-xs btn-default">Tee uusi luokka</a>
            <?php } ?>
        </form>
    </div>

</div>
</div>
