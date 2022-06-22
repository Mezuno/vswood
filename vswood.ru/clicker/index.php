<?php 

session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}
$title = 'Кликер';
$page = 'clicker';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;

$id = $user['id'];
$clickerData = $db->query("SELECT * FROM `clicker` WHERE `playerId` = '$id'")->fetch_assoc();

function getPrice($price, $multiply, $countBooster, $boosterMultiply) {
    if ($countBooster == 0) return $price; 
    for ($i = $countBooster; $i > 0; $i--) {
        $price = $price * $multiply;
    }
    return $price + $countBooster*$boosterMultiply;
}
 ?>


<section class="clicker">
    <div class="clicker__row flex-row flex-just-sparnd flex-alit-center flex-wrap">
        <div class="clicker__column flex-col">
            <p class="" id="points"><?= $clickerData['points']; ?></p>
            <div class="button-box">
                <button class="clicker__button" id="addPointsButton"></button>
            </div>
            <input type="hidden" name="id" value="<?= $id; ?>">
        </div>
        <div class="clicker__column">
            <div class="clicker__shop shop">
                <ul class="shop__list">
                    <li class="shop__item flex-row flex-alit-center">
                        <p class="shop__title">Booster</p>
                        <p class="shop__count">Count</p>
                        <p class="shop__gain">Gain</p>
                    </li>
                    <li class="shop__item flex-row flex-alit-center">
                        <p class="shop__title">Hand</p>
                        <p class="shop__count" id="handsCount"></p>
                        <p class="shop__gain" id="handsGain"></p>
                        <button class="shop__button" id="addHandButton">Buy(<span id="handPrice"><?= round(getPrice(100, 1.15, $clickerData['hands'], 0.05)) ?></span>)</button>
                    </li>
                    <li class="shop__item flex-row flex-alit-center">
                        <p class="shop__title">Friend</p>
                        <p class="shop__count" id="friendsCount"></p>
                        <p class="shop__gain" id="friendsGain"></p>
                        <button class="shop__button" id="addFriendButton">Buy(<span id="friendPrice"><?= round(getPrice(1000, 1.2, $clickerData['friends'], 0.1)) ?></span>)</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>

$(document).on('click', '#addPointsButton', function() {addPoints(1);});

function getPrice(price, multiply, countBooster, boosterMultiply) {
	if (countBooster == 0) return price; 
    for (i = countBooster; i > 0; i--) {
        price = price * multiply;
    }
    return price + countBooster*boosterMultiply;
}

//////////////////// ADD HAND
$(document).on('click', '#addHandButton', function() {
var id=$("input[name=id]").val();

if (id === undefined) {return false;}
$.ajax({
            type: "POST",
            url:  "addBooster.php",
            data: {"id":id, "boosterType":'hand'},
            dataType: 'json',
            success: function(response) {
                $("#points").empty();
                $("#points").append(response.points);
                $("#handsCount").empty();
                $("#handsCount").append(response.hands);
                $("#handsGain").empty();
                $("#handsGain").append(response.hands+'pps');
                $("#handPrice").empty();
                $("#handPrice").append(Math.round(getPrice(100, 1.15, response.hands, 0.05)));
                actionBoosters(response.hands, response.friends);                 
            }

    });
  });
//////////////////// ADD HAND END


//////////////////// ADD FRIEND
$(document).on('click', '#addFriendButton', function() {
var id=$("input[name=id]").val();

if (id === undefined) {return false;}
$.ajax({
            type: "POST",
            url:  "addBooster.php",
            data: {"id":id, "boosterType":'friend'},
            dataType: 'json',
            success: function(response) {
                $("#points").empty();
                $("#points").append(response.points);
                $("#friendsCount").empty();
                $("#friendsCount").append(response.friends);
                $("#friendsGain").empty();
                $("#friendsGain").append(response.friends * 8+'pps');
                $("#friendPrice").empty();
                $("#friendPrice").append(Math.round(getPrice(1000, 1.2, response.friends, 0.1)));
                actionBoosters(response.hands, response.friends);     
            }

    });
  });
//////////////////// ADD FRIEND END


function addPoints(count) {
var id=$("input[name=id]").val();


if (id === undefined) {return false;}
$.ajax({
            type: "POST",
            url:  "addPoint.php",
            data: {"id":id, "count":count},
            dataType: 'json',
            success: function(response) {
                $("#points").empty();
                $("#points").append(response.points);
            }

    });
}



function actionBoosters(hands, friends) {
    if (typeof handsInterval !== 'undefined') {clearInterval(handsInterval);}
    if (typeof friendsInterval !== 'undefined') {clearInterval(friendsInterval);}
    if (hands != 0) {handsInterval = setInterval(addPoints, 1000, hands);}
    if (friends != 0) {friendsInterval = setInterval(addPoints, 1000, (8*friends));}
    
    
}


function checkBoosters() {
var id=$("input[name=id]").val();
    $.ajax({
            type: "POST",
            url:  "checkBoosters.php",
            data: "id=" + id,
            dataType: 'json',
            success: function(response) {
                $("#points").empty();
                $("#points").append(response.points);
                $("#handsCount").empty();
                $("#handsCount").append(response.hands);
                $("#handsGain").empty();
                $("#handsGain").append(response.hands+'pps');
                $("#friendsCount").empty();
                $("#friendsCount").append(response.friends);
                $("#friendsGain").empty();
                $("#friendsGain").append(response.friends * 8+'pps');
                actionBoosters(response.hands, response.friends);
            }

    });
}


checkBoosters();

</script>