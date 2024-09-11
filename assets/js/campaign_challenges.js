$(document).ready(function () {
	$('.campaign-mission-challenge').on('click', function () {
		let campaignMissionDifficulty = $(this).parents('.campaign-mission-challenges-difficulty')
		let campaignMissions = campaignMissionDifficulty.find('.campaign-mission-challenge')

		// Previous missions difficulties toggle.
		let campaignMissionDifficulties = $('.campaign-mission-challenges-difficulty')
		let clickedCampaignMissionDifficultyIndex = campaignMissionDifficulty.index()
		let clickedMissionNumber = $(this).data('missionNumber')
		let clickedMissionIsChecked = $(this).hasClass('checked')

		let challengesArray = [];

		campaignMissionDifficulties.each(function () {
			let campaignMissionDifficultyIndex = $(this).index()

			if (campaignMissionDifficultyIndex === clickedCampaignMissionDifficultyIndex) {
				campaignMissions.each(function () {
					let missionNumber = $(this).data('missionNumber')
					if (clickedMissionIsChecked && missionNumber >= clickedMissionNumber) {
						$(this).removeClass('checked')
						challengesArray.push($(this).data('id'))
					} else if (!clickedMissionIsChecked && missionNumber <= clickedMissionNumber) {
						$(this).addClass('checked')
						challengesArray.push($(this).data('id'))
					}
				})
			} else if (campaignMissionDifficultyIndex < clickedCampaignMissionDifficultyIndex) {
				if (!clickedMissionIsChecked) {
					let campaignMissionChallenge = $(this).find('.campaign-mission-challenge')
					campaignMissionChallenge.addClass('checked')
					campaignMissionChallenge.each(function (index, campaignMission) {
						challengesArray.push($(this).data('id'))
					})

					$(this).find('input[role="switch"]').prop('checked', true);
				}
			} else if (campaignMissionDifficultyIndex > clickedCampaignMissionDifficultyIndex) {
				if (clickedMissionIsChecked) {
					let campaignMissionChallenge = $(this).find('.campaign-mission-challenge')
					campaignMissionChallenge.addClass('checked')
					campaignMissionChallenge.each(function (index, campaignMission) {
						challengesArray.push($(this).data('id'))
					})

					campaignMissionChallenge.removeClass('checked')
					$(this).find('input[role="switch"]').prop('checked', false);
				}
			}
		})

		clickedMissionIsChecked = $(this).hasClass('checked')

		$.ajax({
			type: "POST",
			url: '/challenges/' + (clickedMissionIsChecked === true ? 'complete' : 'remove'),
			data: {
				"challenges": challengesArray
			},
		});
	})

	$('.campaign-mission-challenges-difficulty input[role="switch"]').on('click', function () {
		let campaignMissionDifficulty = $(this).parents('.campaign-mission-challenges-difficulty')
		let campaignMissions = campaignMissionDifficulty.find('.campaign-mission-challenge')

		// Previous missions difficulties toggle.
		let campaignMissionDifficulties = $('.campaign-mission-challenges-difficulty')
		let clickedCampaignMissionDifficultyIndex = campaignMissionDifficulty.index()
		let switchIsChecked = $(this).prop('checked')

		let challengesArray = [];

		campaignMissionDifficulties.each(function () {
			let campaignMissionDifficultyIndex = $(this).index()
			if (campaignMissionDifficultyIndex === clickedCampaignMissionDifficultyIndex) {
				campaignMissions.each(function () {
					if (!switchIsChecked) {
						$(this).removeClass('checked')
					} else {
						$(this).addClass('checked')
					}
					challengesArray.push($(this).data('id'))
				})
			} else if (campaignMissionDifficultyIndex < clickedCampaignMissionDifficultyIndex) {
				if (switchIsChecked) {
					let campaignMissionChallenge = $(this).find('.campaign-mission-challenge')
					campaignMissionChallenge.addClass('checked')
					campaignMissionChallenge.each(function (index, campaignMission) {
						challengesArray.push($(this).data('id'))
					})

					campaignMissionChallenge.addClass('checked')
					$(this).find('input[role="switch"]').prop('checked', true);
				}
			} else if (campaignMissionDifficultyIndex > clickedCampaignMissionDifficultyIndex) {
				if (!switchIsChecked) {
					let campaignMissionChallenge = $(this).find('.campaign-mission-challenge')
					campaignMissionChallenge.addClass('checked')
					campaignMissionChallenge.each(function (index, campaignMission) {
						challengesArray.push($(this).data('id'))
					})

					campaignMissionChallenge.removeClass('checked')
					$(this).find('input[role="switch"]').prop('checked', false);
				}
			}
		})

		$.ajax({
			type: "POST",
			url: '/challenges/' + (switchIsChecked === true ? 'complete' : 'remove'),
			data: {
				"challenges": challengesArray
			},
		});
	})
})