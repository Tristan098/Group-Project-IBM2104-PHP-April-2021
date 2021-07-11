<?php
  // Start the session
  session_start();
  // session_destroy();

  require 'config.php';
?>

<?php include 'header.php';?>

<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
        <form action="index.php" method="GET">
          <div class="card shadow mt-3" style="margin-top:20px!important;">
            <div class="card-header">
              <h5>Filter
                <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
              </h5>
            </div>
            <div class="card-body">
              <?php
              $con = mysqli_connect("localhost","root","","data");

              $query = "SELECT * FROM menu";
              $query_run = mysqli_query($con, $query);

              ?>
              <h5>Destination</h5>
              <hr>
              <?php
              // TESTING -- START
              if(mysqli_num_rows($query_run) > 0) {
                $sql = "SELECT DISTINCT destination, id FROM menu ORDER BY destination";
                $result = $con -> query($sql);

                while($row = $result -> fetch_assoc()) {
                  // $row['destination']
                  $checked = [];
                  if(isset($_GET['destinations']))
                  {
                    $checked = $_GET['destinations'];
                  }
                  ?>

                  <div>
                    <input type="checkbox" name="destinations[]" value="<?= $row['id']; ?>"
                    <?php if(in_array($row['id'], $checked)){ echo "checked"; } ?>
                    />

                    <?= $row['destination']; ?>
                  </div>

                  <?php
                }
              }
              else {
                echo "No Destination Found!";
              }
              // TESTING -- END
              ?>

              <h5>Rating</h5>
              <hr>
              <?php
              // TESTING -- START
              if(mysqli_num_rows($query_run) > 0) {
                $sql = "SELECT DISTINCT rating FROM menu ORDER BY rating";
                $result = $con -> query($sql);

                while($row = $result -> fetch_assoc()) {
                  $checked = [];

                  if(isset($_GET['ratings'])) {
                    $checked = $_GET['ratings'];
                  }
                  ?>

                  <div>
                    <input type="checkbox" name="ratings[]" value="<?php echo $row['rating'] ?>"
                    <?php if(in_array($row['rating'], $checked)){ echo "checked"; } ?>
                    />

                    <?= number_format((double)$row['rating'],1,'.',''); ?> Star/s
                  </div>

                  <?php
                }
              }
              else {
                echo "No Rating Found!";
              }
              // TESTING -- END
              ?>

              <h5>Total Time</h5>
              <hr>
              <?php
              // TESTING -- START
              if(mysqli_num_rows($query_run) > 0) {
                $sql = "SELECT DISTINCT total FROM menu ORDER BY total";
                $result = $con -> query($sql);

                while($row = $result -> fetch_assoc()) {
                  $checked = [];

                  if(isset($_GET['totals'])) {
                    $checked = $_GET['totals'];
                  }
                  ?>

                  <div>
                    <input type="checkbox" name="totals[]" value="<?php echo $row['total'] ?>"
                    <?php if(in_array($row['total'], $checked)){ echo "checked"; } ?>
                    />

                    <?= $row['total']; ?>
                  </div>

                  <?php
                }
              }
              else {
                echo "No Total Time Found!";
              }
              // TESTING -- END
              ?>

              <h5>Interval</h5>
              <hr>
              <?php
              // TESTING -- START
              if(mysqli_num_rows($query_run) > 0) {
                $sql = "SELECT DISTINCT pickup FROM menu ORDER BY pickup";
                $result = $con -> query($sql);

                while($row = $result -> fetch_assoc()) {
                  $checked = [];

                  if(isset($_GET['pickups'])) {
                    $checked = $_GET['pickups'];
                  }
                  ?>

                  <div>
                    <input type="checkbox" name="pickups[]" value="<?php echo $row['pickup'] ?>"
                    <?php if(in_array($row['pickup'], $checked)){ echo "checked"; } ?>
                    />

                    <?= $row['pickup']; ?>
                  </div>

                  <?php
                }
              }
              else {
                echo "No Time Interval Found!";
              }
              // TESTING -- END
              ?>

              <h5>Price</h5>
              <hr>
              <?php
              // TESTING -- START
              if(mysqli_num_rows($query_run) > 0) {
                $sql = "SELECT DISTINCT price FROM menu ORDER BY price";
                $result = $con -> query($sql);

                while($row = $result -> fetch_assoc()) {
                  $checked = [];

                  if(isset($_GET['prices'])) {
                    $checked = $_GET['prices'];
                  }
                  ?>

                  <div>
                    <input type="checkbox" name="prices[]" value="<?php echo $row['price'] ?>"
                    <?php if(in_array($row['price'], $checked)){ echo "checked"; } ?>
                    />

                    RM<?= $row['price']; ?>.00
                  </div>

                  <?php
                }
              }
              else {
                echo "No Price Found!";
              }
              // TESTING -- END
              ?>
            </div>
          </div>
        </form>
      </div>

      <div class="col-lg-9">
        <h3 id="textChange"> List Of Destinations</h3>
        <h6 class="location">23 Locations</h6>
        <hr>
        <div class="row" id="result">
          <?php
          $sql="SELECT * FROM menu";
          // TESTING -- START
          $destinationsStr = '';
          $ratingsStr = '';
          $totalsStr = '';
          $pickupsStr = '';
          $pricesStr = '';

          // for filtering destinations
          if (isset($_GET['destinations'])) {
            // settle the where statement
            $destinationsStr = 'id IN(';
            for ($i = 0; $i < sizeof($_GET['destinations']); $i++)
            $destinationsStr .= $_GET['destinations'][$i] . ',';

            // remove comma
            $size = strlen($destinationsStr);
            if (substr($destinationsStr, $size-1, 1) == ',')
            $destinationsStr = substr($destinationsStr, 0, $size-1);
            $destinationsStr .= ')';
          }

          // for filtering ratings
          if (isset($_GET['ratings'])) {
            // generate the where statement for ratings
            $ratingsStr = 'rating IN(';
            for ($i = 0; $i < sizeof($_GET['ratings']); $i++)
            $ratingsStr .= $_GET['ratings'][$i] . ',';

            // remove comma
            $size = strlen($ratingsStr);
            if (substr($ratingsStr, $size-1, 1) == ',')
            $ratingsStr = substr($ratingsStr, 0, $size-1);
            $ratingsStr .= ')';
          }

          // for filtering total time
          if (isset($_GET['totals'])) {
            // generate the where statement for totals
            $totalsStr = 'total IN(';
            for ($i = 0; $i < sizeof($_GET['totals']); $i++)
            $totalsStr .= $_GET['totals'][$i] . ',';

            // remove comma
            $size = strlen($totalsStr);
            if (substr($totalsStr, $size-1, 1) == ',')
            $totalsStr = substr($totalsStr, 0, $size-1);
            $totalsStr .= ')';
          }

          // for filtering interval
          if (isset($_GET['pickups'])) {
            // generate the where statement for pickups
            $pickupsStr = 'pickup IN(';
            for ($i = 0; $i < sizeof($_GET['pickups']); $i++)
            $pickupsStr .= $_GET['pickups'][$i] . ',';

            // remove comma
            $size = strlen($pickupsStr);
            if (substr($pickupsStr, $size-1, 1) == ',')
            $pickupsStr = substr($pickupsStr, 0, $size-1);
            $pickupsStr .= ')';
          }

          // for filtering prices
          if (isset($_GET['prices'])) {
            // generate the where statement for pickups
            $pricesStr = 'price IN(';
            for ($i = 0; $i < sizeof($_GET['prices']); $i++)
            $pricesStr .= $_GET['prices'][$i] . ',';

            // remove comma
            $size = strlen($pricesStr);
            if (substr($pricesStr, $size-1, 1) == ',')
            $pricesStr = substr($pricesStr, 0, $size-1);
            $pricesStr .= ')';
          }

          // completing the sql query
          $strArray = array($destinationsStr, $ratingsStr, $totalsStr, $pickupsStr, $pricesStr);
          $isFirst = true;
          for ($j = 0; $j < sizeof($strArray); $j++) {
            if ($isFirst && $strArray[$j] != '') {
              $sql .= " WHERE " . $strArray[$j];
              $isFirst = false;
            }
            else if ($strArray[$j] != '') {
              $sql .= " AND " . $strArray[$j];
            }
          }

          // echo "<script>alert('$sql');</script>";
          // exit();
          // TESTING -- END

          $result=$con->query($sql);
          while($row=$result->fetch_assoc()) {
            ?>
            <div class="col-md-3 mb-2">
              <div class="card border-secondary">
                <img style="height:200px;" src="<?= $row['image']; ?>">
                <div class="card-body">
                  <div class="card-img-top">
                    <h6 style="margin-top:5px; margin-bottom:10px;" class="text-light bg-info text-center rounded p-1"><?= $row['destination']; ?></h6>
                  </div>
                  <h4 style="color:blue;">Rating: <?= number_format((double)$row['rating'],1,'.',''); ?> Star/s</h4>
                  <p>
                    Total Time: <?= $row['total']; ?><br>
                    Bus Interval: <?= $row['pickup']; ?><br>
                    Price: RM<?= $row['price']; ?>.00<br>
                  </p>
                  <a href="booking.php?action=1&id=<?php echo $row['id'] ?>" class="btn btn-dark btn-primary btn-sm btn-book">Book</a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
