var TxtRotate = function(el, toRotate, period) {
	this.toRotate = toRotate;
	this.el = el;
	this.loopNum = 0;
	this.period = parseInt(period, 10) || 2000;
	this.txt = '';
	this.tick();
	this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
	var i = this.loopNum % this.toRotate.length;
	var fullTxt = this.toRotate[i];

	if (this.isDeleting) {
		this.txt = fullTxt.substring(0, this.txt.length - 1);
	} else {
		this.txt = fullTxt.substring(0, this.txt.length + 1);
	}

	this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

	var that = this;
	var delta = 300 - Math.random() * 100;

	if (this.isDeleting) { delta /= 2; }

	if (!this.isDeleting && this.txt === fullTxt) {
		delta = this.period;
		this.isDeleting = true;
	} else if (this.isDeleting && this.txt === '') {
		this.isDeleting = false;
		this.loopNum++;
		delta = 500;
	}

	setTimeout(function() {
		that.tick();
	}, delta);
};

window.onload = function() {
	var elements = document.getElementsByClassName('txt-rotate');
	for (var i=0; i<elements.length; i++) {
		var toRotate = elements[i].getAttribute('data-rotate');
		var period = elements[i].getAttribute('data-period');
		if (toRotate) {
			new TxtRotate(elements[i], JSON.parse(toRotate), period);
		}
	}
	var css = document.createElement("style");
	css.type = "text/css";
	css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
	document.body.appendChild(css);
};


$(function () {

	$('#auto-region.autocomplete').autocomplete({
		data: {
			"NIR - Negros Island Region" : null,
			"NCR - National Capital Region": null,
			"CAR - Cordillera Administrative Region": null,
			"REGION I - Ilocos": null,
			"REGION II - Cagayan Valley": null,
			"REGION III -Central Luzon": null,
			"REGION IV-A - CALABARZON": null,
			"REGION IV-B - MIMAROPA": null,
			"REGION V - Bicol": null,
			"REGION VI - Western Visayas": null,
			"REGION VII -Centra Visayas": null,
			"REGION VIII - Eastern Visayas": null,
			"REGION IX - Zamboanga Peninsula": null,
			"REGION X - Northern Mindanao": null,
			"REGION XI - Davao": null,
			"REGION XII - Soccsksargen": null,
			"REGION XIII - Caraga": null,
			"ARMM - Autonomous Region in Muslim Mindanao": null,
		},
		limit: 5,
		onAutoComplete: function(val) {

		},
		minLength: 1,
	});
});


$(document).ready(function(){
	$('.stepper').activateStepper();
	$('.stepper').activateStepper({
      linearStepsNavigation: true, //allow navigation by clicking on the next and previous steps on linear steppers
      autoFocusInput: true, //since 2.1.1, stepper can auto focus on first input of each step
      autoFormCreation: true, //control the auto generation of a form around the stepper (in case you want to disable it)
      showFeedbackLoader: true //set if a loading screen will appear while feedbacks functions are running
  });
	$(".button-collapse").sideNav();
	$('select').material_select();
	<!-- please add this to document.ready-->
	$('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 120 // Creates a dropdown of 15 years to control year
            });
	$(".button-collapse").sideNav();
	$('.modal').modal();
	$('select').material_select();
	$('.materialboxed').materialbox();
	$('.chips').material_chip();
	$('.chips-initial').material_chip({
		data: [{
			tag: 'Apple',
		}, {
			tag: 'Microsoft',
		}, {
			tag: 'Google',
		}],
	});
	$('.chips-placeholder').material_chip({
		placeholder: 'Enter a tag',
		secondaryPlaceholder: '+Tag',
	});
	$('.chips-autocomplete').material_chip({
		autocompleteOptions: {
			data: {
				'Apple': null,
				'Microsoft': null,
				'Google': null
			},
			limit: Infinity,
			minLength: 1
		}
	});

	$('.chips').keyup(function () {
		var data= $('#tag').material_chip('data');
		// console.log(data);

		var myTags = ''; 

		for (var i = 0; i< data.length; i++) {
			myTags += '<input type="hidden" value="' + data[i].tag + '" name="tags[]">';
			$('#tags').html(myTags);
		}
	});

});

