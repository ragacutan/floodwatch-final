<?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
	
   require 'backend/db.php';
   
   $select = "SELECT `sensor`  FROM `waterstatus` ORDER BY `id` DESC LIMIT 1";
   $query = mysqli_query($connection, $select);
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>FloodWatch</title>
      <meta http-equiv="refresh" content="300">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway&display=swap">
      <link rel="stylesheet" href="styles.css">
   </head>
   <body>
          <header>
        <div class="logo-container">
            <a href="admin/login.php"><img src="LOGO/logo.png" alt="FloodWatch Logo" class="logo"></a>
            <h1>FloodWatch</h1>
        </div>
        <div class="registration-btn">
            <a href="admin/subscribe.php">Subscribe</a>
        </div>
    </header>
      <main>
         <div class="weather-display">
         <?php
            $weather_api_key = 'de2fab5eb72d1d53a9c48fbc67e76782';
            $latitude = '16.602909';
            $longitude = '120.362862';
            $weather_url = "https://api.openweathermap.org/data/2.5/weather?lat=$latitude&lon=$longitude&units=metric&appid=$weather_api_key";
            
            $response = file_get_contents($weather_url);
            $weather_data = json_decode($response, true);
            
            if ($weather_data) {
                $weather_description = $weather_data['weather'][0]['description'];
                $temperature = $weather_data['main']['temp'];
                $weather_icon = $weather_data['weather'][0]['icon'];
                $date_time = date('l, F j, Y - ');
                $icon_url = "http://openweathermap.org/img/w/$weather_icon.png";
            
                echo "<div class='weather-text'>";
                echo "$temperature &deg;C | <img src='$icon_url' alt='Weather Icon' class='weather-icon'> $weather_description</div>";
            
                echo "<div class='date-time'>";
                echo "<p> $date_time <span id='demo'></span></p>";
                echo "</div>";
            } else {
                echo "<p>Weather data unavailable.</p>";
            }
            ?>
         <div class='water-level-status'>
            <?php
               $num = mysqli_num_rows($query);
               $waterLevelStatus = "";
               
               if ($num > 0) {
                   while ($row = mysqli_fetch_array($query)) {
                       echo "Water Level: ";
                       $waterlevel = $row['sensor'];
               
                       if($waterlevel == "sensor_1"){
                            $waterLevelStatus = "<span class='filled-box green-box'>Low</span> ";
                       }elseif($waterlevel == "sensor_2"){
                            $waterLevelStatus = "<span class='filled-box yellow-box'>Alert!</span>";
                       }elseif($waterlevel == "sensor_3"){
                            $waterLevelStatus = "<span class='filled-box orange-box'>Alarm!</span>";
                       }elseif($waterlevel == "sensor_4"){
                            $waterLevelStatus = "<span class='filled-box red-box'>Critical!</span>";
                       }else{
                            $waterLevelStatus = "<span class='filled-box white-box'></span>";
                       }
                   }
               }
               echo $waterLevelStatus;
               ?>
         </div>
         <div class="flood-advisory">
            <div class="flood-advisory-container">
               <h2>Flood Advisory</h2>
               <?php
                  // Insert dynamic text based on water level status
                    if($waterlevel == "sensor_1"){
                        echo "<p>Low Level. Current water level is safe. No flood advisory at the moment.</p>";
                    }elseif($waterlevel == "sensor_2"){
                        echo "<p>Alarm! The water level is rising. Stay alert for potential flooding.</p>";
                    }elseif($waterlevel == "sensor_3"){
                        echo "<p>Alert! Flooding is imminent. Take necessary precautions.</p>";
                    }elseif($waterlevel == "sensor_4"){
                        echo "<p>Critical! Severe flooding expected. Evacuation may be necessary.</p>";
                    }else{
                        echo "<p>Water level status is unknown. Please check for updates.</p>";
                    }
                  ?>
               <!-- You can add more content or dynamic data here as needed -->
            </div>
         </div>
         <div class="water-Level">
            <div class="water-container">
               <h2>Water Level Status</h2>
               <h1><mark class="evacuation">EVACUATE</mark></h1>
               <p>Serious Flooding is expected in low-lying areas! Evacuation in Needed!</p>
               <h1><mark class="prepare">PREPARE</mark></h1>
               <p>Prepare your survival for possible evacuation Flooding is Threatening</p>
               <h1><mark class="alert">ALERT AND MONITOR</mark></h1>
               <p>Monitoring water level Possible Flooding</p>
               <h1><mark class="low-level">LOW WATER LEVEL</mark></h1>
               <p>Observation of weather</p>
            </div>
         </div>
         <div class="flood-safety-rules">
            <h1>Flood Safety Rules</h1>
            <div class="flood-safety">
               <h1>BEFORE THE FLOOD</h1>
               <ul>
                  <li>Find out how often your location is likely to be flooded.</li>
                  <li>Know the flood warning system in your community and be sure your family knows it.</li>
                  <li>Keep informed of daily weather conditions.</li>
                  <li>Designate an evacuation area for the family and livestock.</li>
                  <li>Assign family members instructions and responsibilities according to an evacuation plan.</li>
                  <li>Keep a stock of food which requires little cooking and refrigeration; electric power may be interrupted.</li>
                  <li>Keep a transistorized radio and flashlight with spare batteries, emergency cooking equipment, candies, matches, and a first aid kit handy in case of emergency.</li>
                  <li>Store supplies and other household effects above expected flood water level.</li>
                  <li>Securely anchor weak dwellings and items.</li>
               </ul>
            </div>
            <div class="flood-safety">
               <h1>WHEN WARNED OF FLOOD</h1>
               <ul>
                  <li>Watch for rapidly rising flood waters.</li>
                  <li>Listen to your radio for emergency instructions.</li>
                  <li>If you find it necessary to evacuate, move to a safe area before access is cut off by flood waters.</li>
                  <li>Store drinking water in containers, as water service may be interrupted.</li>
                  <li>Move household belongings to upper levels.</li>
                  <li>Get livestock to higher ground.</li>
                  <li>Turn off electricity at the main switch in the building before evacuating and also lock your house.</li>
               </ul>
            </div>
            <div class="flood-safety">
               <h1>DURING THE FLOOD</h1>
               <ul>
                  <li>Avoid areas subject to sudden flooding.</li>
                  <li>Do not attempt to cross rivers or flowing streams where water is above the knee.</li>
                  <li>Beware of water-covered roads and bridges.</li>
                  <li>Avoid unnecessary exposure to the elements.</li>
                  <li>Do not go swimming or boating in swollen rivers.</li>
                  <li>Eat only well-cooked food. Protect leftovers against contamination.</li>
                  <li>Drink clean or preferably boiled water ONLY.</li>
               </ul>
            </div>
            <div class="flood-safety">
               <h1>AFTER THE FLOOD</h1>
               <ul>
                  <li>Re-enter the dwellings with caution using flashlights, not lanterns or torches. Flammables may be inside.</li>
                  <li>Be alert for fire hazards like broken wires.</li>
                  <li>Do not eat food and drink water until they have been checked for flood water contamination.</li>
                  <li>Report broken utility lines (electricity, water, gas, and telephone) to appropriate agencies authorities.</li>
                  <li>Do not turn on the main switch or use appliances and other equipment until they have been checked by a competent electrician.</li>
                  <li>Consult health authorities for immunization requirements.</li>
                  <li>Do not go in disaster areas. Your presence might hamper rescue and other emergency operations.</li>
               </ul>
            </div>
            <div class="flood-safety">
               <h1>THINGS ONE CAN DO TO MITIGATE FLOODS</h1>
               <ul>
                  <li>Regulate cutting of trees.</li>
                  <li>Report illegal loggers and kaingeros.</li>
                  <li>Report illegal construction of fishponds and other establishments in waterways.</li>
                  <li>Do not throw garbage in esteros and rivers.</li>
                  <li>Help clean the neighborhood.</li>
                  <li>Support community activities intended to lessen the occurrence of floods.</li>
                  <li>Avoid throwing anything like plastic wrappers anywhere which may clog or block the drainage system.</li>
               </ul>
               <p>Source: <a href="https://www.pagasa.dost.gov.ph/learning-tools/floods" target="_blank">https://www.pagasa.dost.gov.ph/learning-tools/floods</a></p>
            </div>
         </div>
         <div class="emergency-hotlines">
            <h2>Emergency Hotlines</h2>
            
            <a href="https://www.google.com/maps/place/Ilocos+Training+and+Regional+Medical+Center/@16.5938984,120.3130887,17z/data=!4m10!1m2!2m1!1sitrmc!3m6!1s0x33918fb5a88b90a9:0x6d79ddc12e2c7d60!8m2!3d16.5912317!4d120.3178203!15sCgVpdHJtY5IBE2dvdmVybm1lbnRfaG9zcGl0YWzgAQA!16s%2Fg%2F1tfvqh6c?entry=ttu">
               <div class="hotline-container">
                  <img src="LOGO/itrmc.png" alt="Emergency Service Logo" class="hotline-logo">
                  <p>ITRMC</p>
                  <p>(072) 607 6418</p>
                  <p>Sevilla</p>
                  <p>San Fernando</p>
            </div>
            </a>

            <a href="https://www.google.com/maps/place/San+Fernando+City+Police+Station/@16.6174333,120.3229705,20z/data=!4m9!1m2!2m1!1scity+disaster+risk+reduction+management!3m5!1s0x339191c55df5aa1d:0x85f3dc8e27c939e1!8m2!3d16.6174777!4d120.3234703!16s%2Fg%2F11bzvv_bfv?entry=ttu">
               <div class="hotline-container">
                  <img src="LOGO/pro1.png" alt="Emergency Service Logo" class="hotline-logo">
                  <p>CSF POLICE STATION</p>
                  <p>(072) 607-8954</p>
                  <p>0915 558 8888</p>
                  <p>0939 812 6888</p>
               </div>
            </a>

            <a href="https://www.google.com/maps/place/San+Fernando+City+Fire+Station/@16.6102289,120.3348723,13z/data=!4m10!1m2!2m1!1sbfp+san+fernando+la+union!3m6!1s0x33918e6a5940755f:0xaeff20973e234cff!8m2!3d16.6170426!4d120.3173656!15sChliZnAgc2FuIGZlcm5hbmRvIGxhIHVuaW9ukgEMZmlyZV9zdGF0aW9u4AEA!16s%2Fg%2F11bzvw2r_0?entry=ttu">
               <div class="hotline-container">
                  <img src="LOGO/bfp.png" alt="Emergency Service Logo" class="hotline-logo">
                  <p>BUREAU OF FIRE PROTECTION</p>
                  <p>(072) 607-7880</p>
                  <p>0917 183 8711</p>
                  <p>0927 723 6885</p>
               </div>
            </a>

            <a href="https://www.google.com/maps/@16.6172462,120.3235869,21z?entry=ttu">
               <div class="hotline-container">
                  <img src="LOGO/cdrrmc.png" alt="Emergency Service Logo" class="hotline-logo">
                  <p>CSF CDRRMO</p>
                  <p>(072) 619 2437</p>
                  <p>0917 676 7673</p>
                  <p>0928 522 0622</p>
               </div>
             </a>
         </div>
         <div class="evacuation-center">
         <h2>Evacuation Center</h2>
         <div class="evacuation-center-container">
            <div class="evacuation-info">
               <div class="evacuation-location">
                  <p><a href="https://www.google.com/maps/place/Sevilla+Barangay+Hall/@16.595899,120.3183962,17z/data=!3m1!4b1!4m6!3m5!1s0x33918fb382ee6439:0xf928600e620e9d2b!8m2!3d16.5958939!4d120.3209711!16s%2Fg%2F11h8dw970t?entry=ttu">Sevilla Brgy. Hall</a></p>
                  <p><a href="https://www.google.com/maps/place/Barangay+Hall,+Madayegdeg/@16.5995173,120.3122436,17z/data=!3m1!4b1!4m6!3m5!1s0x33918f9c0ab9efa9:0x3a2504db99e76548!8m2!3d16.5995173!4d120.3148185!16s%2Fg%2F11vlqdq6n3?entry=ttu">Madayegdeg Brgy. Hall</a></p>
               </div>
            </div>
            <div class="evacuation-info">
               <div class="evacuation-location">
                  <p><a href="https://www.google.com/maps/place/Catbangen+Central+School/@16.6127507,120.3096063,17z/data=!3m1!4b1!4m6!3m5!1s0x33918e43a54cde19:0xce22225dd3a79f78!8m2!3d16.6127507!4d120.3121812!16s%2Fg%2F1tdcjh4n?entry=ttu">Catbangen Central School</a></p>
                  <p><a href="https://www.google.com/maps/place/Catbangen+Barangay+Hall,+Mabini+St,+San+Fernando,+2500+La+Union/@16.610663,120.3083852,17z/data=!3m1!4b1!4m6!3m5!1s0x33918e449b7985a7:0x8ef23390ec526db3!8m2!3d16.6106741!4d120.310959!16s%2Fg%2F11b8td4ttx?entry=ttu">Catbangen Brgy. Hall</a></p>
               </div>
            </div>
            <div class="evacuation-info">
               <div class="evacuation-location">
                  <p><a href="https://www.google.com/maps/place/J88F%2BVCP,+P.+Burgos+St,+San+Fernando,+La+Union/@16.6172462,120.3235869,21z/data=!4m6!3m5!1s0x33918e1454388f11:0x37403f3f75813a91!8m2!3d16.6171766!4d120.3236182!16s%2Fg%2F11kgxprwc7?entry=ttu">Senior Citizen Hall</a></p>
                  <p><a href="https://www.google.com/maps/place/Marcos+Building,+F.+Ortega+Highway,+San+Fernando,+La+Union/@16.6117232,120.3081881,16z/data=!4m5!3m4!1s0x33918e6a8cab9e37:0xa37b962102dedec1!8m2!3d16.6164826!4d120.3179822?entry=ttu">4th Floor of Marcos Building</a></p>
               </div>
            </div>
         </div>
      </main>
      <section class="waves-section">
         <div class="wave wave1"></div>
         <div class="wave wave2"></div>
         <div class="wave wave3"></div>
         <div class="wave wave4"></div>
      </section>
      <footer>
         <div style="background-color: smokewhite; color: black; text-align: center; padding: 10px; font-weight: bold; ">
            <p>Flood Monitoring & Early Warning</p>
            <p>@FloodWatch 2023</p>
         </div>
      </footer>
      <script>
         function myClock() {
             setTimeout(function () {
                 const d = new Date();
                 const n = d.toLocaleTimeString();
                 document.getElementById("demo").innerHTML = n;
                 myClock();
             }, 1000)
         }
         myClock();
      </script>

      <script>
        function myClock() {
            // Your existing clock function

            setTimeout(function () {
                // Reload the content every 5 minutes (300 seconds)
                location.reload();
            }, 10000); // 300,000 milliseconds = 5 minutes
        }
        myClock();
    </script>

    
   </body>
</html>