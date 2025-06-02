(function ($) {
	"use strict";

	function parents(element, selector) {
		const parentsArray = [];
		let currentElement = element.parentElement;

		while (currentElement !== null) {
			if (currentElement.matches(selector)) {
				parentsArray.push(currentElement);
			}
			currentElement = currentElement.parentElement;
		}

		return parentsArray;
	}

	document.addEventListener("DOMContentLoaded", () => {

		var switcher = document.querySelectorAll('.redux-container-switch');

		if (switcher.length) {

			switcher.forEach(swtch => {

				let on = swtch.querySelector('.cb-enable'),
					off = swtch.querySelector('.cb-disable');

				if (on.classList.contains('selected')) {

					swtch.classList.add('sw--on');

				} else {

					swtch.classList.remove('sw--on');
				}
				
				swtch.addEventListener('click' , () => {
					
					swtch.classList.toggle('sw--on');
					
					if (swtch.classList.contains('sw--on')) {
						
						off.click();
					} else {
						on.click();
					}
					
				})



			})

		}

		let typo = document.querySelectorAll('.redux-container-typography');

		if (typo.length) {

		typo.forEach(ty => {

			let tabField = parents(ty , '.redux-tab-field');
			

			if (tabField.length) {

				tabField.forEach(tb => {
					// tb.classList.add('typo--field')
				})

			}


		})


		}
		


	});


})(jQuery)
