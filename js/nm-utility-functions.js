// Javascript Utility-Funktionen für Net-Metrix Monthly

// Zahlenfunktionen
function cleanString2Number(str) {
        return (str.match(/['.,]/)) ? Number(str.replace(/[.,']/g, "")) : Number(str);
};

function toNumber(str) {
        switch (typeof(str)) {
            case 'number':
                str = cleanString2Number(str.toString());
                break; // We convert numbers to strings because we need to get rid of thousands separators that ma be there
            case 'string':
                str = cleanString2Number(str);
                break;
            default:
                console.log('Not permissible as argument of toNumber()', str);
                str = 0; // Anything that isn't a number or string will be set to 0 and a message will be written to the console
        };
        return str;
};

function runde(zahl) {
	 return Math.round(toNumber(zahl)/10000)/100;
};


