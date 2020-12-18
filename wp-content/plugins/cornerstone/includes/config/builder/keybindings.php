<?php

/**
 * Can be modifed via this filter: cornerstone_keybindings
 *
 * For single keys, you can add a prefix to ensure a behavior
 * keydown:
 * keyup:
 *
 * Be careful. Everything is bound as "Global" meaning it will take
 * effect even is a user is working in a textarea or text input.
 */

return array(
  'save'                   => array( 'mod+s',       __('Save','cornerstone') ),
  'undo'                   => array( 'mod+z',       __('Undo Element Change','cornerstone') ),
  'redo'                   => array( 'mod+shift+z', __('Redo Element Change','cornerstone') ),
  'delete'                 => array( 'delete',      __('Delete Element','cornerstone') ),
  'duplicate'              => array( 'mod+d',       __('Duplicate Element','cornerstone') ),
  'copy'                   => array( 'mod+c',       __('Copy Element','cornerstone') ),
  'paste'                  => array( 'mod+v',       __('Paste Element','cornerstone') ),
  'paste-style'            => array( 'mod+shift+v', __('Paste Element Style','cornerstone') ),
  'find'                   => array( 'mod+f',       __('Find (focus available search)','cornerstone') ),
  'toggle-full-collapse'   => array( 'mod+shift+a', __('Hide/Show Workspace','cornerstone') ),
  'toggle-elements'        => array( 'mod+shift+e', __('Toggle Elements Library','cornerstone') ),
  'esc'                    => array( 'esc',         __('Close Open Window','cornerstone') ),
  'nav-builder-outline'   => array( 'mod+option+1', __('Outline', 'cornerstone') ),
  'nav-builder-inspector' => array( 'mod+option+2', __('Inspector', 'cornerstone') ),
  'nav-builder-settings'  => array( 'mod+option+3', __('Settings', 'cornerstone') ),
  'nav-theme-options'     => array( 'mod+option+4', __('Theme Options', 'cornerstone') ),
  'toggle-ui-theme'        => array( 'mod+shift+u',  false ),
  'goto-headers'           => array( 'mod+option+h', false ),
  'goto-content'           => array( 'mod+option+c', false ),
  'goto-footers'           => array( 'mod+option+f', false ),
  'goto-layouts'           => array( 'mod+option+l', false ),
  // 'goto-templates'         => array( 'mod+option+t', false ),
  'goto-global-blocks'     => array( 'mod+option+g', false ),
  // 'goto-design-cloud'      => array( 'mod+option+d', false ),
  // 'goto-theme-options'     => array( 'mod+option+o', false ),
  'goto-fonts'             => array( 'mod+option+t', false ),
  'goto-colors'            => array( 'mod+option+k', false ),
  // 'goto-history'           => array( 'mod+option+y', false ),
  // 'advanced-mode'          => array( 'mod+shift+x', false ), // __('Toggle Advanced Mode','cornerstone')

);
