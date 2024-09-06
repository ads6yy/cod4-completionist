$(document).ready(function () {
	$('.camouflage-weapon .camouflage').on('click', function () {
		let camouflageWeapon = $(this).parents('.camouflage-weapon')
		let camouflages = camouflageWeapon.find('.camouflage:not(.default)')
		if (!$(this).hasClass('default')) {
			$(this).toggleClass('checked')
		}

		let camouflagesChecked = camouflageWeapon.find('.camouflage.checked')
		if (camouflages.length === camouflagesChecked.length) {
			camouflageWeapon.addClass('checked')
		} else {
			camouflageWeapon.removeClass('checked')
		}
	})

	$('.camouflage-weapon .weapon-name').on('dblclick', function () {
		let camouflageWeapon = $(this).parents('.camouflage-weapon')
		let camouflages = camouflageWeapon.find('.camouflage:not(.default)')
		camouflageWeapon.toggleClass('checked')
		camouflages.removeClass('checked')
		if (camouflageWeapon.hasClass('checked')) {
			camouflages.addClass('checked')
		}
	})
})