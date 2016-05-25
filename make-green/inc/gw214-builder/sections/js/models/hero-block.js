/* global Backbone, jQuery, _ */
var oneApp = oneApp || {};

(function (window, Backbone, $, _, oneApp) {
	'use strict';

	oneApp.HeroBlockModel = Backbone.Model.extend({
		defaults: {
			id: '',
			parentID: '',
			sectionType: 'heroblock'
		}
	});

	// Set up this model as a "no URL model" where data is not synced with the server
	oneApp.HeroBlockModel.prototype.sync = function () { return null; };
	oneApp.HeroBlockModel.prototype.fetch = function () { return null; };
	oneApp.HeroBlockModel.prototype.save = function () { return null; };
})(window, Backbone, jQuery, _, oneApp);