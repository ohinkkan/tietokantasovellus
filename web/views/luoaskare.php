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
            Nimi: <input type="text" value="<?php echo $_SESSION['taskdata']['name'] ?>" name = "name">
            Tärkeys:
            <select class="btn btn-default btn-xs" name = "priority">
                <?php
                foreach ($_SESSION['taskdata']['priorities'] as $current) {
                    ?>
                    <option value="<?php echo $current->getId() ?>"<?php
                    if ($current->getId() === $_SESSION['taskdata']['priority']) {
                        echo "selected";
                    }
                    ?>><?php echo $current->getName() ?></option>
                        <?php } ?>
            </select>
            <h4>Kuvaus:</h4>
            <textarea rows="4" style="width:100%" name = "descr"><?php echo $_SESSION['taskdata']['descr'] ?></textarea>
            <br>
            <br>  <div class="btn-group">
                Lisää luokka:
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    Valitse luokka <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php if (empty($_SESSION['taskdata']['tasktypes'])) { ?>
                        <li><a href="askareluokat.php">Ei yhtään luokkaa määritettynä, klikkaa mennäksesi luontisivulle</a></li>
                    <?php
                    }
                    foreach ($_SESSION['taskdata']['tasktypes'] as $type) {
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
                        foreach ($_SESSION['taskdata']['newtasktypes'] as $typeid) {
                            ?>
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo tasktype::getTasktypeName($typeid) ?></td>
                                <td><a href="askareenluonti.php?id=<?php echo $_SESSION['taskdata']['modifytask'] ?>&remove=<?php echo $typeid ?>" role="button" class="btn btn-xs btn-default">Poista</a></td>
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
            <?php if ($_SESSION['modify']) { ?>
                <a href="askareenluonti.php?new=true" role="button" class="btn btn-xs btn-default">Tee uusi askare</a>
            <?php } ?>
        </div>
    </form>
</div>

