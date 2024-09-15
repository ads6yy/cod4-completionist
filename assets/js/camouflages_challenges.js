$(document).ready(function () {
	$('.camouflage-weapon .camouflage:not(.default)').on('click', function () {
		if ($('body').hasClass('user-logged')) {
			let camouflageWeapon = $(this).parents('.camouflage-weapon')
			let camouflages = camouflageWeapon.find('.camouflage:not(.default)')

			if (!$(this).hasClass('default')) {
				$(this).toggleClass('checked')
			}

			let challengesArray = [];
			challengesArray.push($(this).data('id'))

			let clickedCamouflageIndex = camouflages.index($(this))
			let clickedCamouflageIsChecked = $(this).hasClass('checked');

			camouflages.each(function (index, camouflage) {
				if (clickedCamouflageIsChecked && index < clickedCamouflageIndex) {
					$(this).addClass('checked')
					challengesArray.push($(this).data('id'))
				} else if (!clickedCamouflageIsChecked && index > clickedCamouflageIndex) {
					$(this).removeClass('checked')
					challengesArray.push($(this).data('id'))
				}
			})

			let camouflagesChecked = camouflageWeapon.find('.camouflage:not(.default).checked')
			if (camouflages.length === camouflagesChecked.length) {
				camouflageWeapon.addClass('checked')
				challengesArray.push(camouflageWeapon.data('id'))
			} else {
				camouflageWeapon.removeClass('checked')
			}

			$.ajax({
				type: 'POST',
				url: '/challenges/' + (clickedCamouflageIsChecked === true ? 'complete' : 'remove'),
				data: {
					'challenges': challengesArray
				}
			});
		} else {
			$('[data-bs-target="#loginModal"]').click()
		}
	})

	$('.camouflage-weapon .weapon-name').on('dblclick', function () {
		if ($('body').hasClass('user-logged')) {
			let camouflageWeapon = $(this).parents('.camouflage-weapon')
			let camouflages = camouflageWeapon.find('.camouflage:not(.default)')
			camouflageWeapon.toggleClass('checked')
			camouflages.removeClass('checked')
			if (camouflageWeapon.hasClass('checked')) {
				camouflages.addClass('checked')
			}

			let challengesArray = [];
			challengesArray.push(camouflageWeapon.data('id'))
			camouflages.each(function (index, camouflage) {
				challengesArray.push($(this).data('id'))
			})

			let checked = camouflageWeapon.hasClass('checked');
			$.ajax({
				type: 'POST',
				url: '/challenges/' + (checked === true ? 'complete' : 'remove'),
				data: {
					'challenges': challengesArray
				}
			});
		} else {
			$('[data-bs-target="#loginModal"]').click()
		}
	})
})