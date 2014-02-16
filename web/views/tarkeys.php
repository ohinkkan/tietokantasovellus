<div>
    <div style="float:left">
        <h3>Tärkeysasteet</h3>
    </div>

    <div style="float:right">
        <br>
        <form action = "tarkeysasteet.php" method = "get">
            Filtteröi listaa: <input type = "text" name = "filter" value = "<?php echo $_SESSION['prioritydata']['filter'] ?>"/>
            <input type ="hidden" name ="typeid" value="<?php $_SESSION['prioritydata']['active'] ?>">
            <button type = "submit">Filtteröi</button>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nimi</th>
                <th>Suhteellinen tärkeys (isompi on tärkeämpi)</th>
                <th>Poista</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($_SESSION['prioritydata']['priorities'] as $priority) {
                ?>
                <?php if ($priority->filter($_SESSION['prioritydata']['filter'])) { ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><a href="tarkeysasteet.php?typeid=<?php echo $priority->getId() ?>&filter=<?php echo htmlspecialchars($_GET["filter"]) ?>"><?php echo $priority->getName() ?></a></td>
                        <td>
                            <?php
                            echo $priority->getImportance();
                            $count++
                            ?>
                        </td>
                        <td><a href="tarkeysasteet.php?remove=<?php echo $priority->getId() ?>" role="button" class="btn btn-xs btn-default">Poista</a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <div class="subsection">
        <form action = "tarkeystarkistus.php" method = "POST">
            <?php if ($_SESSION['modify']) { ?>
                <h4>Muokkaa tärkeysastetta</h4>
            <?php } else { ?>
                <h4>Tee uusi tärkeysaste</h4>
            <?php } ?>
            Nimi: <input type="text" value="<?php echo $_SESSION['prioritydata']['name'] ?>" name = "name">
            Suhteellinen tärkeys, isompi on tärkeämpi:
            <select class="btn btn-default btn-xs" name = "importance">
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    ?>
                    <option value="<?php echo $i ?>"<?php
                        if ($i == $_SESSION['prioritydata']['importance']) {
                            echo "selected";
                        }
                        ?>>
                        <?php echo $i ?></option>
                <?php } ?>
            </select>
            <br>
            <br>
            <button type="submit" class="btn btn-xs btn-default">Tallenna</button>
            <?php if ($_SESSION['modify']) { ?>
                <a href="tarkeysasteet.php?new=true" role="button" class="btn btn-xs btn-default">Tee uusi tärkeysaste</a>
            <?php } ?>
        </form>
    </div>

</div>
</div>
