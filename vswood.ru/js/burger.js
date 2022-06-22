// Биг мак
const iconMenu = document.querySelector('.burger-menu');

if (iconMenu) {

	const aside = document.querySelector('.aside');
	const asidecol = document.querySelector('.aside__column');
	const header = document.querySelector('.header');
	const wrapper = document.querySelector('.wrapper');

	iconMenu.addEventListener("click", function(e) {
		iconMenu.classList.toggle('_active');
		aside.classList.toggle('_active');
		asidecol.classList.toggle('_active');
		header.classList.toggle('_move');
		wrapper.classList.toggle('_move');
	});
}