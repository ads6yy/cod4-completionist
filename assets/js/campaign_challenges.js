$(document).ready(function () {
	$('.campaign-mission-challenge').on('click', function () {
		let campaignMissionDifficulty = $(this).parents('.campaign-mission-challenges-difficulty')
		let campaignMissions = campaignMissionDifficulty.find('.campaign-mission-challenge')

		// Previous missions difficulties toggle.
		let campaignMissionDifficulties = $('.campaign-mission-challenges-difficulty')
		let clickedCampaignMissionDifficultyIndex = campaignMissionDifficulty.index()
		let clickedMissionNumber = $(this).data('missionNumber')
		let clickedMissionIsChecked = $(this).hasClass('checked')

		campaignMissionDifficulties.each(function () {
			let campaignMissionDifficultyIndex = $(this).index()

			if (campaignMissionDifficultyIndex === clickedCampaignMissionDifficultyIndex) {
				campaignMissions.each(function () {
					let missionNumber = $(this).data('missionNumber')
					if (clickedMissionIsChecked && missionNumber >= clickedMissionNumber) {
						$(this).removeClass('checked')
					} else if (!clickedMissionIsChecked && missionNumber <= clickedMissionNumber) {
						$(this).addClass('checked')
					}
				})
			} else if (campaignMissionDifficultyIndex < clickedCampaignMissionDifficultyIndex) {
				if (!clickedMissionIsChecked) {
					$(this).find('.campaign-mission-challenge').addClass('checked')
					$(this).find('input[role="switch"]').prop('checked', true);
				}
			} else if (campaignMissionDifficultyIndex > clickedCampaignMissionDifficultyIndex) {
				if (clickedMissionIsChecked) {
					$(this).find('.campaign-mission-challenge').removeClass('checked')
					$(this).find('input[role="switch"]').prop('checked', false);
				}
			}
		})
	})

	$('.campaign-mission-challenges-difficulty input[role="switch"]').on('click', function () {
		let campaignMissionDifficulty = $(this).parents('.campaign-mission-challenges-difficulty')
		let campaignMissions = campaignMissionDifficulty.find('.campaign-mission-challenge')

		// Previous missions difficulties toggle.
		let campaignMissionDifficulties = $('.campaign-mission-challenges-difficulty')
		let clickedCampaignMissionDifficultyIndex = campaignMissionDifficulty.index()
		let switchIsChecked = $(this).prop('checked')

		campaignMissionDifficulties.each(function () {
			let campaignMissionDifficultyIndex = $(this).index()
			if (campaignMissionDifficultyIndex === clickedCampaignMissionDifficultyIndex) {
				campaignMissions.each(function () {
					if (!switchIsChecked) {
						$(this).removeClass('checked')
					} else {
						$(this).addClass('checked')
					}
				})
			} else if (campaignMissionDifficultyIndex < clickedCampaignMissionDifficultyIndex) {
				if (switchIsChecked) {
					$(this).find('.campaign-mission-challenge').addClass('checked')
					$(this).find('input[role="switch"]').prop('checked', true);
				}
			} else if (campaignMissionDifficultyIndex > clickedCampaignMissionDifficultyIndex) {
				if (!switchIsChecked) {
					$(this).find('.campaign-mission-challenge').removeClass('checked')
					$(this).find('input[role="switch"]').prop('checked', false);
				}
			}
		})
	})
})