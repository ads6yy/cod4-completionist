$(document).ready(function () {
	$('.multiplayer-challenge').on('click', function () {
		$(this).toggleClass('checked')

		let challengesArray = [];
		challengesArray.push($(this).data('id'))

		let clickedIsChecked = $(this).hasClass('checked');

		$.ajax({
			type: "POST",
			url: '/challenges/' + (clickedIsChecked === true ? 'complete' : 'remove'),
			data: {
				"challenges": challengesArray
			},
		});
	})
})