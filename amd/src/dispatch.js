// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * dispatch js
 *
 * @package    mod_sharedgeogebra
 * @copyright   2020 Devlion <info@devlion.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([
    "jquery",
    "core/templates"
], function ($, Templates) {
    "use strict";
    return {
        init: function (type, url, title) {
            $('#sharedgeogebrasessioniframe').ready(function() {
                let element = $('#sharedgeogebrasessioniframe');

                Templates.render('mod_sharedgeogebra/' + type, {url:url, name:title}).done(function(html, js) {
                    element.after(html);
                    Templates.runTemplateJS(js);
                });
            });
        }
    };
});
