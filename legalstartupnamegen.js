/* Online Name Generators v.2.0 script is  made by Niels Gamborg webmaster at online-generator.com
*  and Andrew Cabasso from jurispage.com.
*  The script is  free (as in "free speech" and also as in "free beer") in anyway. Use it after you own likings.
*  Peace and love. :)
*/

function generator() {

  // Add your own words to the wordlist. Be careful to obey the syntax shown

  var wordlist1 = ["Forward","Law","Juris","Docu","Corpus","Dictum","Bill",

    "Docu","Flat","Right","Incorp","Easy","EZ","Iron","Will",

    "Clause", "Web","Serve","Firm","Juxta","Fiscal","e","i","Case",

    "Term","Patent","Habeas","Estate","Clear","Legis",

    "Contractu", "Crowd","Amicus","File","Viewa","Hirea",

    "We","Evolve","Lex","Supra","Id","Alt","Plain","Docket",

    "Best","Ever","Simple","Attorney","Cosmo","Diligence","Sky","Up","Logik",

    "Ravel","Panda","Shake","My"];


  var wordlist2 = ["Docs","Law","Pivot","Dingo","Legal","Page","Kick",

    "Legal","Words","Regs","Bench","Geek","ese","clad",

    "fty","Match","Preserver","Manager","Central","Note","Run",

    "Go","Start","Guru","Genie","Finder","lytics","Monk","Sumo",

    "Ninja","Counsel","Defend","HQ","Map","opolis","stat",

    "Folders","Crunch","Base","cus","pect","Trades","Up","Point",

    "NDA","wordy","Rails","Air","Hero","Monkeys","Site","Scout",

    "scale","Booker","Court","Alarm","Fee","Rate","Stage",

    "Engine","Analytics","cull","Machina","Flex","text","trek"];


  var wordlist3 = [" "," "," "," "," "," "," "," "," "," "," "," "," ",

    " "," "," "," "," "," "," "," "," "," "," "," "," ",

    "ist","ly","search","gram","book",

    "er","cu","Hackers","able"]

  // Random numbers are made

  var randomNumber1 = parseInt(Math.random() * wordlist1.length);

  var randomNumber2 = parseInt(Math.random() * wordlist2.length);

  var randomNumber3 = parseInt(Math.random() * wordlist3.length);

  var name = wordlist1[randomNumber1] + wordlist2[randomNumber2] + wordlist3[randomNumber3];

  // alert(name); //Remove first to slashes to alert the name

  // If there's already a name it is removed

  if(document.getElementById("result")){

    document.getElementById("placeholder").removeChild(document.getElementById("result"));

	}

	// A div element is created to show the generated name. The Name is added as a textnode. Textnode is added to the placeholder.

	var element = document.createElement("h3");

	element.setAttribute("id", "result");

	element.appendChild(document.createTextNode(name));

	document.getElementById("placeholder").appendChild(element);

}
