/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.HeroView = oneApp.SectionView.extend({

		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttfmake-add-block' : 'addBlock'
			});
		},

		addBlock: function (evt, params) {
			evt.preventDefault();

			var view, html;

			// Create view
			view = new oneApp.HeroBlockView({
				model: new oneApp.HeroBlockModel({
					id: new Date().getTime(),
					parentID: this.getParentID()
				})
			});

			// Append view
			html = view.render().el;
			$('.ttfmake-hero-blocks-stage', this.$el).append(html);

			// Only scroll and focus if not triggered by the pseudo event
			if ( ! params ) {
				// Scroll to added view and focus first input
				oneApp.scrollToAddedView(view);
			}

			// Initiate the color picker
			oneApp.initializeHeroBlocksColorPicker(view);

			// Add the section value to the sortable order
			oneApp.addOrderValue(view.model.get('id'), $('.ttfmake-hero-block-order', $(view.$el).parents('.ttfmake-hero-blocks')));
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttfmake-section-', '');

			return parseInt(id, 10);
		}
	});

	// Makes hero blocks sortable
	oneApp.initializeHeroBlocksSortables = function(view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttfmake-hero-blocks-stage', view.$el);
		} else {
			$selector = $('.ttfmake-hero-blocks-stage');
		}

		$selector.sortable({
			handle: '.ttfmake-sortable-handle',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttfmake-hero-blocks-stage');

				$('.sortable-placeholder', $stage).height($item.height());
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttfmake-hero-blocks'),
					$orderInput = $('.ttfmake-hero-block-order', $stage);

				oneApp.setOrder($(this).sortable('toArray', {attribute: 'data-id'}), $orderInput);
			}
		});
	};

	// Initialize the color picker
	oneApp.initializeHeroBlocksColorPicker = function (view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.gw214-configuration-color-picker', view.$el);
		} else {
			$selector = $('.gw214-configuration-color-picker');
		}

		$selector.wpColorPicker({
			hide: false
		});
	};

	// Initialize the sortables
	$oneApp.on('afterSectionViewAdded', function(evt, view) {
		if ('hero' === view.model.get('sectionType')) {
			// Add an initial block item
			$('.ttfmake-add-block', view.$el).trigger('click', {type: 'pseudo'});

			// Initialize the sortables
			oneApp.initializeHeroBlocksSortables(view);
		}
	});

	// Initialize available blocks
	oneApp.initHeroBlockViews = function ($el) {
		$el = $el || '';
		var $blocks = ('' === $el) ? $('.ttfmake-hero-block') : $('.ttfmake-hero-block', $el);

		$blocks.each(function () {
			var $item = $(this),
				idAttr = $item.attr('id'),
				id = $item.attr('data-id'),
				$section = $item.parents('.ttfmake-section'),
				parentID = $section.attr('data-id'),
				model, view;

			// Build the model
			model = new oneApp.HeroBlockModel({
				id: id,
				parentID: parentID
			});

			// Build the view
			view = new oneApp.HeroBlockView({
				model: model,
				el: $('#' + idAttr),
				serverRendered: true
			});

			oneApp.initializeHeroBlocksColorPicker(view);
		});

		oneApp.initializeHeroBlocksSortables();
	};

	// Initialize the views when the app starts up
	oneApp.initHeroBlockViews();
})(window, jQuery, _, oneApp, $oneApp);

