# ACF - Field Selector

A field for Advanced Custom Fields which allows users to select a list of created custom fields

## Description

The filed selector field allows the selection of other custom fields. This is useful in situations where you want to give the user powerful display options. You could, for example, allow the user to select which custom fields are displayed in a post.

#### Thanks

- [Advanced Custom Fields](http://www.advancedcustomfields.com/) for the awesome base plugin.
- [Alexei Ryazancev](https://www.iconfinder.com/GlumPix) for the plugin icon

#### Translations

The plugin is currently available in English and Hungarian. Please feel free to submit any new languages via a pull request, I'd be mighty thankful.

#### Useful Links

This Github repository is for the development of this plugin. If you would like to read installation and in-depth usage instructions you might want to look at the WordPress plugin page instead.

- [Plugin Page](https://wordpress.org/plugins/acf-field-selector-field/)
- [SVN Repository](http://plugins.svn.wordpress.org/acf-field-selector-field/)
- [ACF Plugin](https://wordpress.org/plugins/advanced-custom-fields/)
- [ACF Home Page](http://www.advancedcustomfields.com/)
- [ACF Documentation](http://www.advancedcustomfields.com/resources/)
- [ACF Field Template](https://github.com/elliotcondon/acf-field-type-template)
- [ACF on Github](https://github.com/elliotcondon/acf)


# For Developers

For developers I've included a filter which allows you to further filter selected fields. At the moment this filter is used to make sure that included and excluded types and groups are reflected in the selectable list.

`add_filter( 'acffsf/item_filters', 'selectable_item_filter', 10, 2 )`

The first parameter is the list of items to modify, the second is the setting field.

# Want To Help?

If you like the plugin and you like helping others out there are a few things you can do:

- **[Buy ACF Pro](http://www.advancedcustomfields.com/pro/)**
- **[Review the plugin](https://wordpress.org/support/view/plugin-reviews/acf-field-selector-field)**
- **Submit a translation** If you speak another language goodly, you can submit a language file, I'd be mighty thankful! Take a look at the lang directory to see what languages we already have. If a language isn't there create one and submit a pull request. If you have no idea what I'm talking about drop me a line and I'll help you out
- **[Tip me on Gratipay](https://gratipay.com/danielpataki/)**
