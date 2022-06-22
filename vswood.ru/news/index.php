<?php
$title = 'Новости';
$page = 'News';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;
?>



<section class="news">
	<div class="news__row">

			<?php 
				$result = $db->query("SELECT * FROM `news` ORDER BY `id` DESC");
				
				while ($news = $result->fetch_assoc()) {

					$title = '<div class="news__title">'.$news['title'].'</div>';
					$img = '<div class="news__img"><img src="../img/news/'.$news['id'].'.jpg" alt="Картинка новости"></div>';
					$text = '<div class="news__text">'.$news['text'].'</div>';
					/* Достаём юзнейм автора из бд по id */
					$authorId = $news['authorId'];
					$resultAuthor = $db->query("SELECT `login` FROM `users` WHERE `id` = '$authorId'");
					$resultAuthorName = $resultAuthor->fetch_assoc();

					$authorAndTime = '<div class="news__time small-text gray-text">'.$resultAuthorName['login'].' от '.$news['time'].'</div>';


					echo '<div class="news__item">'.$title.$img.$text.$authorAndTime.'</div>';
				}
			 ?>
	</div>
</section>


</div> <!-- Закрывает Window -->
</div> <!-- Закрывает Wrapper -->
</body>
</html>