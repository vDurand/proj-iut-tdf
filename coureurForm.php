<form method="post" action="" name="ajoutCoureur" class="ink-form">
    <fieldset class="all-33">
        <legend><?php if(basename($_SERVER['PHP_SELF']) == "addCoureur.php"){echo "Ajout Coureur";}else{echo "Modification Coureur";} ?></legend>
        <div class="control-group required">
            <label for="nom">Nom</label>
            <div class="control">
                <input value="<?php echo $nom; ?>" autofocus required type="text" id="nom" name="nom" pattern="<?php echo $pattern; ?>">
            </div>
        </div>
        <div class="control-group required">
            <label for="prenom">Prénom</label>
            <div class="control">
                <input value="<?php echo $prenom; ?>" required type="text" id="prenom" name="prenom" pattern="<?php echo $pattern; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="anneen">Année de naissance</label>
            <div class="control">
                <input value="<?php echo $annee_n; ?>" type="number" name="annee_n" id="anneen" max="<?php echo date("Y"); ?>" min="1900">
            </div>
        </div>
        <div class="control-group required">
            <label for="pays">Pays</label>
            <div class="control">
                <select required name="pays">
                    <option value=''></option>
                    <?php
                    $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                    $cur = ExecuterRequete($conn, $req);
                    $nbLigne = LireDonnees1($cur, $tab);
                    foreach($tab as $key => $val) {
                        if($val['CODE_TDF'] == $pays)
                            echo "<option selected value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        else
                            echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label for="anneetdf">Année tour de France</label>
            <div class="control">
                <input value="<?php echo $annee_tdf; ?>" type="number" id="anneetdf" name="annee_tdf" pattern="^[0-1]{4}" min="<?php echo date("Y"); ?>">
            </div>
        </div>
        <input class="ink-button green" name="submit" type="submit" value="<?php if(basename($_SERVER['PHP_SELF']) == "addCoureur.php"){echo "Ajouter";}else{echo "Modifier";} ?>">
        <input class="ink-button" name="reset" type="reset" value="Vider les champs">
    </fieldset>
</form>