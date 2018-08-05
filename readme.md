#PHP Tic Tac Toe App
These App for implementing tic tac toe game as a php [ Laravel ] , HTML, CSS, JQuery.

### Installation
1. clone : `https://github.com/abdullahalnahhal/tic-tac-toe.git`.
2. Config the App open `.env` file or just use the `.env.example` by removing the `.example` and type `php artisan key:generate` on the Terminal.
3. Conig the `DB` information such as `DB_HOST`, `DB_PORT`, `DB_DATABASE`, and etc... .
4. On the Terminal Type `php artisan migrate`.
5. On the  Terinal Type `php artisan db:seed`.
6. On the Terminal Type `./vendor/bin/phpunit`.


------------

## Files And Directories
##### Controller Files
We Have two Main Controllers :
- Web : `App/Http/Controllers/HomeController`.
-It works for initiate, create new player and game, and initiate Token on the player table.
-Has two Methods `index` : to call `startGame` method [ entry point ] and return it on the view.
-Has two Methods `startGame` : for initiating the player and Game.

- Api : `App/Http/Controllers/Api/PlayController` .
-It works as an entry point for the play logic.
-We can Othenticate the user on the Middleware `APIToken.php`.
-Has six Methods 
			`index` : Initiate Player, Gaming, Slots ,and Board .
			`Play` : Entrty point for playing.
			`winOrLoose` : Checks if the player [ human/computer ] win, loose, or game over.
			`humanPlay` : making a play for the human player.
			`computerPlay` : making a play for the computer player.
			`mssages` : used for returning the messages that returned to the user.
##### Brain Files
###### Directory `App/Gaming`
- `Slot` Presents the slot podition (x, y) point.
-It has two methods 
		`__construct` : to Initiate Slot .
		`__get` : to get the slot point x or y .
- `SlotsIterator` Presents group of slots and it implements `Iterator` interface and extends the `App/Gaming/Abstracts/SlotsIteratorAbstract` .
-it has five methods
		`__set` : As a setter it can't accept any variable except Slot object
		`count` : As counter for the internal slots.
		`rand` : Returns random slot.
		`unst` : Unset the selected slot from the group
		`source` : Returns an array of Slots.
- `Board` Presents the 3 * 3 Board that the user play on it and extends `App/Gaming/Abstracts/BoardAbstract`
-It has 12 methods 
		`__construct` : Works as initiator method entry point.
		`initHumanSlots` : initiate the human slots on these board as `SlotsIterator` object
		`initComputerSlots` : initiate the computer slots on these board as `SlotsIterator` object.
		`initFreeSlots` : initiate the free slots on these board as `SlotsIterator` object.
		`addHumanSlot` : To add new slot the human slots in these board.
		`addComputerSlot` : To add new slot the computer slots in these board.
		`removeFreeSlot` : To remove a slot from free slots in these board.
		`isFreeSlot` : Checks if these slot is free or not.
		`isRow` : Checks if these group of slots presents a row [ vertical slots ] or not.
		`isColumn` : Checks if these group of slots presents a column [ horizontal slots ] or not.
		`isLDiag` : Checks if these group of slots presents a left diagonal [ like \ ] or not.
		`isRDiag` : Checks if these group of slots presents a right diagonal [ like / ] or not.
- `Player` Presents a player either human or computer and extends `App/Gaming/Abstracts/PlayerAbstract`
-it has two methods 
		`__construct` : initiate variables
		`makeAction` : add Player action to the Players Table
- `Gaming` implements the `App/Gaming/Interfaces/GamingInterface`.
-it has four methods
		`humanPlay` Works as entry Point  for making human play action.
		`computerPlay` Works as entry Point  for making computer play action.
		`isWin` Checks if these group of slots make win or not [ win for human ]
		`isLoose` Checks if these group of slots make loose or not [ win for computer ]