<?php 
require_once("../controller/session_msgs.php");
require_once("../model/functions.php");

if(!(isset($_SESSION['id']) && $_SESSION['role'] == "admin")){
    header("Location: ../view/index.php");
    exit;
}
include("../layout/header.php");
 
open_connetion();
$objs = get_vols_objects("ORDER BY id_vol DESC");
close_connection();
?>
<div class="container">
    <?php echo message();?>
    <ul class="nav nav-tabs justify-content-center mb-5">
        <li class="nav-item">
            <a class="nav-link bg-primary text-white active" data-toggle="tab" href="#addF_light"><i class="fas fa-plus-circle"></i> Ajouter un Vol</a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-primary text-white" data-toggle="tab" href="#togglevol"><i class="far fa-list-alt"></i> La liste des Vols</a>
        </li>
    </ul>
    <div class=" mt-5">
        <div class="container text-dark bg-info" style="border:2px solid  rgb(0, 0, 255,0.8) "id="add_vol">
            <h1 class="text-center "><i class="fas fa-plus-square"></i> Ajouter Nouveau Vol </h1>
            <!-- n_vol, depart, destination, date_vol, price, total_places,statut -->
            <form action="../controller/proc_vol.php" method="POST" class="needs-validation mt-4" novalidate>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="plane "  class="font-weight-bold">Nom de vol:</label>
                            <input type="text" class="form-control" id="plane" placeholder="Nom de vol" name="plane"
                                required>
                        </div><br>
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="datevol" class="font-weight-bold">Date de Vol</label>
                            <input type="date" class="form-control" id="datevol" name="datevol" required>
                        </div><br>
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="hour_vol" class="font-weight-bold">Heure de vol </label>
                            <input type="number" class="form-control" id="hour_vol" placeholder="Heure de vol" name="hour_vol" required>
                        </div><b
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="minute_vol" class="font-weight-bold">Minute de Vol</label>
                            <input type="number" class="form-control" id="minute_vol" placeholder="Minute de vol" name="minute_vol" required>
                        </div><b

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="Dplocation" class="font-weight-bold">Ville de départ</label>
                            <input type="text" class="form-control" id="Dplocation" placeholder="Ville de depart"
                                name="Dplocation" required>
                        </div><br>
                        <div class="col-xs-12 col-sm-6 my-2">
                            <label for="Dslocation" class="font-weight-bold">Ville de destinatin</label>
                            <input type="text" class="form-control" id="Dslocation" placeholder="ville de destination"
                                name="Dslocation" required>
                        </div><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label for="places" class="font-weight-bold">Nombre des places</label>
                            <input type="text" class="form-control" id="places" placeholder="Les du Vol"
                                name="places" required>
                        </div><br>
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label for="cin" class="font-weight-bold">le prix</label>
                            <input type="text" class="form-control" id="price" placeholder="Prix de vol" name="price"
                                required>
                        </div><br>
                        <div class="col-xs-12 col-sm-6 col-lg-3 my-2">
                            <label class="mr-3 font-weight-bold">L'état:</label>
                            <div class="form-control">
                            <label  class="mr-3 font-weight-bold">Aciver <input type="radio" class="form-control" name="isActive" value="1"
                                    checked></label>
                            <label class="mr-3 font-weight-bold">Annuler<input type="radio" class="form-control" name="isActive" value="0"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mb-5 font-weight-bold" name="add_vol">Ajouter</button>
            </form>

        </div>
        <div class="tab-pane container mt-5 fade"  style="border:2px solid  rgb(0, 0, 255,0.8) " id="togglevol">
            <h1 class="text-center" ><i class="fas fa-plane"></i> La liste des Vols</h1>
            <div class="table-responsive">
        <table class="table table-striped mt-4 reserve">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Nom</th>
                    <th>Ville de départ</th>
                    <th>Ville de déstination</th>
                    <th>Date de Vol</th>
                    <th>L'heure de départ</th>
                    <th>Prix</th>
                    <th>Nombre des Places</th>
                    <th>L'état</th>
                </tr>
            </thead>
            <tbody class="thead-light">
            <?php foreach($objs as $vol){ ?>
            <tr class="text-center text-center" >
                <th><?php echo $vol->get_data()["n_vol"];?></th>
                <th><?php echo $vol->get_data()["depart"];?></th>
                <th><?php echo $vol->get_data()["distination"];?></th>
                <th><?php echo $vol->get_data()["date_vol"];?></th>
                <th><?php echo $vol->get_data()["hour_vol"]."h";echo $vol->get_data()["hour_vol"]."min";?></th>
                <th><?php echo $vol->get_data()["price"];?>  eur</th>
                <th><?php echo $vol->get_data()["total_places"];?></th>
                <form action="../controller/proc_vol.php" method="POST">
                <?php 
                if($vol->get_data()["statut"] == 1){
                ?>
                <th><button type="submit" value="<?php echo $vol->get_id();?>" name="change" class="btn btn-warning btn-sm">Annuler</th>
                <?php
                }else {
                ?>
                <th><button type="submit" value="<?php echo $vol->get_id();?>" name="change" class="btn btn-success btn-sm">Activer</button></th>
                <?php }} ?>
                
                </form>
                
            </tr>
            </tbody>
        </table>
    </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>
</body>
 <footer>
<?php 
include("../layout/footer.php"); ?>
</footer>
</html>