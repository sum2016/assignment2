=== doall ===

Contributor: Hyue Lin Kang
Tags: custom post type, widget, recent posts, shortcodes, wordpress
Requires at least: 1.0
Tested up to: 1.0
Stable tag: 0.0.1
License: Hyue Lin Kang
License URI: https://phoenix.sheridanc.on.ca/~ccit3678/

== Description ==

doall is a WordPress plugin that adds a custom post type, a widget that display a set number of posts in recent order and display featured image for each post, and a shortcode that displaying list of old post first and pdf. 

== How to Use ==
**Custom Post Type**
1. In Admin Menu you will find “Custom Post”
2. Just like normal post, page, etc. you can add, edit, and delete

**Widget**
A. Through Admin Page
1. Under “Appearance” Press “Widgets”
2. Find “doall Widget” and drag it to the “Sidebar”
3. You can change the displayed “Title” by entering it into the text box
4. Select from the dropdown menu for “Post Type”
5. Enter in the number of posts you would like to show from the post type you have selected
6. If you wish to display the featured images of the posts, press the box left side of “Display featured image” and a checkmark will appear, which means you are using that setting.
7. If you wish to display the list of posts in a grid format, press the box left side of “Display as grid” and a checkmark will appear, which means you are using that setting.
8. Press “Save” and it will appear according to the setting.

A. Through Site
1. If your logged in as admin you can change the setting live using “Customize” at the top bar
2. Press “Customize”
3. Press “Widgets”
4. Select the location where you are going to use the widget
5. Press “+ Add a Widget”
6. Find “doall Widget” and Press it
7. You can change the displayed “Title” by entering it into the text box
8. Select from the dropdown menu for “Post Type”
9. Enter in the number of posts you would like to show from the post type you have selected
10. If you wish to display the featured images of the posts, press the box left side of “Display featured image” and a checkmark will appear, which means you are using that setting.
11. If you wish to display the list of posts in a grid format, press the box left side of “Display as grid” and a checkmark will appear, which means you are using that setting.
12. Press “Save & Publish” and it will appear according to the setting.

**Shortcodes**
A. Self-closing Shortcode for Displaying List of Old Posts
If you would like to get a list of posts that are old.
1. Go to a new page or a posts
2. Choose either “Text” or “Visual”
3. Now add in: [old-posts posts=“NUMBER” listitle=“TITLE”]
4. Keeping everything the same.... (for Step 5 and 6)
5. Replace NUMBER to integer representing how many posts you would like on the list
6. Replace TITLE to any title you would like to give to this list
7. Press “Publish” or “Update”
8. Shortcode should now be working

B. Enclosing Shortcode for Embedding PDF
If you would like to embed pdf to your post or page.
1. Go to a new page or a posts
2. Choose either “Text” or “Visual”
3. Now add in: [pdf title=“TITLE” link=“LINK” linktxt=“TEXT” width=“WIDTH” height=“HEIGHT”]URL[/pdf]
4. Keeping everything the same.... (for Step 5 and 10)
5. Replace TITLE to any title you would like to give
6. Replace LINK link of the original document
7. Replace TEXT to any text you would like to give, which will appear instead of the link you’ve entered in step 6
8. Replace WIDTH to the width you would like for your PDF
9. Replace HEIGHT to the heigh you would like for you PDF
10. Replace URL with the PDF link
11. Press “Publish” or “Update”
12. Shortcode should now be working