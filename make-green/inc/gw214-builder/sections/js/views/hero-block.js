/* global Backbone, jQuery, _ */
var oneApp = oneApp || {};

(function (window, Backbone, $, _, oneApp) {
	'use strict';

	oneApp.HeroBlockView = Backbone.View.extend({
		template: '',
		className: 'ttfmake-hero-block ttfmake-hero-block-open',

		events: {
			'click .ttfmake-hero-block-remove': 'removeItem',
			'click .ttfmake-hero-block-toggle': 'toggleSection'
		},

		initialize: function (options) {
			this.model = options.model;
			this.idAttr = 'ttfmake-hero-block-' + this.model.get('id');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;
			this.template = _.template($('#tmpl-ttfmake-hero-block').html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON()))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'));
			return this;
		},

		removeItem: function (evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttfmake-hero-blocks'),
				$orderInput = $('.ttfmake-hero-block-order', $stage);

			oneApp.removeOrderValue(this.model.get('id'), $orderInput);

			// Fade and block out the section, then cleanup view
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.remove();
			}.bind(this));
		},

		toggleSection: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$section = $this.parents('.ttfmake-hero-block'),
				$sectionBody = $('.ttfmake-hero-block-body', $section),
				$input = $('.ttfmake-hero-block-state', this.$el);

			if ($section.hasClass('ttfmake-hero-block-open')) {
				$sectionBody.slideUp(oneApp.options.closeSpeed, function() {
					$section.removeClass('ttfmake-hero-block-open');
					$input.val('closed');
				});
			} else {
				$sectionBody.slideDown(oneApp.options.openSpeed, function() {
					$section.addClass('ttfmake-hero-block-open');
					$input.val('open');
				});
			}
		}
	});
})(window, Backbone, jQuery, _, oneApp);