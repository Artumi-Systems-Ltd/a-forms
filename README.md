# Artumi Forms

We've been using a nice form class for years, and now were moving to
Laravel we miss it. So it's time for a rewrite in a way that works
with Laravel.

Why is a form builder style thing a good idea?

1. Get the whole html for the form in a single go.
2. Validation can be provided both via Javascript, and by server side
   messaging.
3. A form contains Widgets which have a number of elements
	- A caption
	- A number of HTML form elements
	- A javascript controlled input
	- A tool tip
	- An example
	- A placeholder
	- An understanding of the Database relations.

I think older form builders seem to want to do less, and so the
benefit is less. Maybe I'm wrong.

We're going to give it a go.

# How to test

`composer test`

# How to add a test

In the `workbench` folder is effectively a laravel app which we can
then use to check that the whole thing works in laravel. So I've got a
"MasterForm" and we can see it's being rendered properly in the
`Feature/WorkbenchTest.php` which for now is such a simple controller
the other moving part is the `workbench/routes/web.php` as opposed to
a proper controller

# Errors

In errors which use the "workbench" laravel testing application, the
errors produced appear in `workbench/storage/logs/laravel.log`


# Creating a Widget

- Make sure you add a `public $allowed` property which contains the
attributes that can be set.
- Make sure you create a test that covers when the widget is not valid
  and when it is, and when it has been changed. Mostly the default
  implementation will work, one that doesn't is the PasswordCreate
  widget because an empty response means "not changed" whereas,
  normally, an empty response would mean someone has emptied the
field.

# Static assets

Any plugins that want to add static assets to a artisan vendor:publish can use
the tag in their service provider of 'aform-widgets'.

# Getting the assets into your template.

The first job is to have the page-asset-manager instantiated and then pass it to `registerAssets()`
which will then do the work of asking the widgets that have been added to the
form to register their requires assets.

You'll want the instantiated class to be a singleton. Then that singleton would be given
to your template to ask it to output the references to the assets in the html.


This package uses artumi-systems-ltd/page-asset-manager for this job, and you should refer
to this:

https://github.com/Artumi-Systems-Ltd/page-asset-manager
