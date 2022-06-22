<?php 

session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}
$title = 'Друзья';
$page = 'friends';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;

$id = $user['id'];
 ?>

 <div class="friends">
     <section class="friends__content">
         <div class="friends__list">
            <?php 
                $id = $_GET['id'];
                $result = $db->query("SELECT * FROM `relation` WHERE ((`user1` = '$id' OR `user2` = '$id') AND `confirmed1` = '1' AND `confirmed2` = '1') ORDER BY `id` DESC");

                while ($resultFriends = $result->fetch_assoc()) {
                    
                    if ($resultFriends['user1'] == $id) {$friendId = $resultFriends['user2'];}
                    if ($resultFriends['user2'] == $id) {$friendId = $resultFriends['user1'];}

                    $resultNick = $db->query("SELECT * FROM `users` WHERE `id` = '$friendId'")->fetch_assoc();

                    if ($resultNick['lastseen'] > time()-60) {
                        $colorLastseen = 'green';
                      } else {$colorLastseen = 'gray-text';}
                      
                        echo '<a href="../profile/?id='.$friendId.'" class="friends__item flex-row flex-alit-center">
                                <img width="40px" height="40px" class="rounded friends__img" src="'.getImgUri($resultNick['id'], 'avatar').'" alt="">
                                <div>
                                    <div class="friends__name small-text">'.$resultNick['login'].'</div>
                                    <div class="friends__last-seen small-text '.$colorLastseen.'">'.getLastSeenById($resultNick['id']).'</div>
                                </div>
                            </a>';
                    $i++;
                }
                if ($i == 0) {
                    echo '<div class="friends__item">У этого пользователя пока нет друзей</div>';
                }


            ?>
         </div>

     </section>
 </div>