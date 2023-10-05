
# Aria Builder
## SetUp
Prerequisite:

 - Docker
 - PHP 8.2
 - Make
 - Composer

 ## Installation
 ### With Make
 Use  `make install` to install our project.
 ### Without Make
 Use These command to install the project.
 

    docker compose up -d
    composer install
    symfony serve
    symfony console doctrine:database:create
    symfony console doctrine:migration:migrate
    symfony console doctrine:fixtures:load

## Usage
Following our domain guideline here is the good use of our api for the different field use the ApiDocumentation @/api
### Create a Character (personnage).
Post Personnage
### Create a Characteristics(Characteristique).
 Post Characteristiques
 with The @id of Character for the field character(personnage)

### Create Base skills (Base Competences) for our Character.
POST Competence
- Character is our character
- Skill(competence) is one of the twenty Base Skill.
Ideally you should submit all the base Skill for one character.

### Choose a Profession for our character.
 PATCH personnage

### Create up to two background for our character
POST Background

 - CompetenceBonus/Malus : CompetencePersonnage@id
 - Personnage : Personnage@id

### Choose up to three skills for Talent
Post Talent
	-personnage : Personnage@id
	-upgradedCompetence: array\<CompetencePersonnage@id> 
