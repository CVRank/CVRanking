= CVRanking Resume =

Provides standardized Resume/ePorfolio fields, CVRank calculation functions, and configurable rankings of resumes (CV Rankings)

== Contents ==

1. Features
2. TO DO
3. Known issues
4. Version History

== 1. Features ==
Visit http://cvrank.org/wiki/cvranking

== 2. TO DO ==
Visit http://cvrank.org/wiki/cvranking

== 3. Known issues ==
None yet!

== 4. Version History ==

1.5 alpha (2012-03-27):

- added: support for 1.8 (multiple changes)
- added: support for CVRank calculations
- changed: objects that were not taken into account for CVRank

1.4.5 (Facyla):

1st round : 20110516
  - merge work + academic + training + reference into experience
  - keep language
  => change object type to "experience"
  => use subtype as a new metadata
  => use common data types (for all "experiences")

2nd round : 20110518
  - add several types and corresponding actions+forms+views : experience, language, education, workexperience, skill, skill_ciiee
    (note : ciiee refers to C2i2e but one can't use number in Elgg data types)
  - lazy normalization to Europass format (contact items are not detailed + skills don't include driving licences yet)
  - move listings from start.php to resume views
  - no longer replace the userdetails view (extend it instead)
  - collapsible boxes are collapsed by default
  - admin settings : activate data types
