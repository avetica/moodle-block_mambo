# MamboIO Gamification Block

Author: Luuk Verhoeven < MoodleFreak.com > , Virgil Ashruf <Avetica.nl>

Requires at least: Moodle 2.6+

This block allows you to map activities to simple and flexible behaviours. You can setup them in mambo.io

## Description

Activities can be mapped to mambo behaviours. On activity completion this will be triggerd with a moodle event.
Also this block syncs users to mambo, on changing it gets updated.

List of features:
- event to delete user from mambo
- event to create user on mambo
- event to sync a fresh enviroment to mambo
- in every course you can add this block and make a activity mapping
- delete of a activity/module triggers a cleanup
- user friendly drag-and-drop for mapping
- translatable
- access controll for setup block
- task for retry if event for behaviour failed before
- On the fly connect to a different mambo site
- Enviroment test include in the settings

## Installation

0.  create a mambo account http://mambo.io
1.  copy this plugin to the blocks\mambo folder on the server
2.  login as administrator
3.  go to Site Administrator > Notification
4.  install the plugin
6.  add your API keys from mambo and pick the correct site after saving
7.  enable completion global
8.  enable completion course based
9.  add a activity and enable completion with some rules
10. add this block to the course and setup your mapping

## Changelog

See github for the complete history, major changes in versions we will list below
