# Kern County College of Law Hearings Watcher

A scraper that searches for cases in the Kern County Criminal Database and displays cases matching predefined search criteria.

As part of the Criminal Procedure course, the students of KCCL have been asked to attend a 
hearing for Motion to Exclude Evidence. The Criminal Court database does not provide 
convenient filter for cases by type, and manual searches take copious amounts of time. Search 
results are unreliable, because they change daily when the schedule is revised.

This program is designed to scrape the database. It will be run on a cron job after midnight on each night, and 
will look forward at the next several days on the court calendar. The data will be stored in a local data file 
so that we can minimize impact on the County website and reduce unnecessary processing time.
