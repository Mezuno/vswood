<?php 
  require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
  require $dblink;

      $result = $db->query("SELECT * FROM `users` WHERE `id` = '".$_POST['id']."' ORDER BY `lastseen` DESC");
      
      while ($userData = $result->fetch_assoc()) {
        $photo = '<img class="pm__selected-img rounded" width="36px" height="36px" src="'.getImgUri($userData['id'], 'avatar').'" alt="">';

              echo '<div class="selected-user flex-just-spbtw">
              <i class="fas fa-arrow-left"></i>
                <a class="user-with-lastseen" href="../profile/?id='.$userData['id'].'">'.$photo.'
                  <div>
                    <p>'.$userData['login'].'</p><p class="small-text gray-text">'.getLastSeenById($userData['id']).'</p>
                  </div>
                </a>
              <div class="selected-user__options gray-text"><i class="fas fa-ellipsis-h"></i>
              <div class="settings">
                <div class="settings__item flex-row flex-alit-center">
                  <button value="'.$userData['id'].'" id="delete-all-chat-button"class="settings__button button">Удалить переписку</button>
                </div>
              </div>
              </div>
              </div>';
      }
 ?>