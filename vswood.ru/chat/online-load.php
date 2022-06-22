<?php 
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
  require $dblink;

      $result = $db->query("SELECT * FROM `users` ORDER BY `lastseen` DESC");
      
      while ($userData = $result->fetch_assoc()) {
        $photo = '<img class="online__user-photo rounded" src="'.getImgUri($userData['id'], 'avatar').'" alt="">&nbsp';

        if ($userData['lastseen'] > time()-60) {
          $colorLastseen = 'green';
        } else {$colorLastseen = 'gray-text';}

        echo '<a class="online__item" href="../profile/?id='.$userData['id'].'">
                '.$photo.'
                <div>
                  <p class="online__name small-text">'.$userData['login'].'</p>
                  <p class="online__last-seen small-text '.$colorLastseen.'">'.getLastSeenById($userData['id']).'</p>
                </div>
              </a>';
      }
 ?>