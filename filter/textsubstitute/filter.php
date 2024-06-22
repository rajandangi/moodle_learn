<?php
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
 * Filter main class for the filter_textsubstitute plugin.
 *
 * @package   filter_textsubstitute
 * @copyright 2024 Rajan Dangi <contact@rajandangi.com.np>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Filter main class for the filter_textsubstitute plugin.
 */
class filter_textsubstitute extends moodle_text_filter {
    /**
     * Apply filter to the text.
     *
     * @see filter_manger::apply_filter_chain().
     * @param string $text The text to be filtered.
     * @param array $options filter options.
     * @return string The filtered text.
     */
    public function filter($text, array $options = []) {
        // Get configs for this plugin.
        $config = get_config('filter_textsubstitute');
        $searchterm = $config->searchterm;
        $replacewith = $config->substituteterm;

        // If the format is not specified or search term is empty, return the text as it is.
        if (!isset($options['originalformat']) || empty($searchterm)) {
            return $text;
        }

        if (in_array($options['originalformat'], explode(',', get_config('filter_textsubstitute', 'formats')))) {
            // Return the modified text.
            return $this->substitute_term($text, $searchterm, $replacewith);
        }
        return $text;
    }

    /**
     * Substitute the search term with the replace term.
     *
     * @param string $text The text to be filtered.
     * @param string $searchterm The search term.
     * @param string $replacewith The term to replace the search term with.
     * @return string The filtered text.
     */
    protected function substitute_term($text, $searchterm, $replacewith) {
        return str_replace($searchterm, $replacewith, $text);
    }
}
