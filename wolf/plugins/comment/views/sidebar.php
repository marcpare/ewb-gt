<?php
/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008,2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * The Comment plugin provides an interface to enable adding and moderating page comments.
 *
 * @package wolf
 * @subpackage plugin.comment
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Bebliuc George <bebliuc.george@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 1.2.0
 * @since Wolf version 0.9.3
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, Bebliuc George & Martijn van der Kleijn, 2008
 */
?>
<p class="button"><a href="<?php echo get_url('plugin/comment/'); ?>"><img src="<?php echo COMMENT_ROOT;?>/images/comment.png" align="middle" alt="page icon" /> <?php echo __('Comments'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/comment/moderation/'); ?>"><img src="<?php echo COMMENT_ROOT;?>/images/moderation.png" align="middle" alt="page icon" /> <?php echo __('Moderation'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/comment/settings'); ?>"><img src="<?php echo COMMENT_ROOT;?>/images/settings.png" align="middle" alt="page icon" /> <?php echo __('Settings'); ?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/comment/documentation/'); ?>"><img src="<?php echo COMMENT_ROOT;?>/images/documentation.png" align="middle" alt="page icon" /> <?php echo __('Documentation'); ?></a></p>