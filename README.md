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
