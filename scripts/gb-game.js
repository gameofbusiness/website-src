function setScore(points)
{
	var max_score = 100, current_points = 0;
	var max_points = points.length * max_score;
	for (var i=0; i < points.length; i++)
	{
		current_points += points[i];
	}
	return parseInt(current_points * max_score / max_points);
}

function setLevel(scores)
{
	var max_level = 100, current_score = 0;
	var max_score = scores.length * max_level;
	for (var i=0; i < scores.length; i++)
	{
		current_score += scores[i];
	}
	var cur_level = parseInt(current_score * max_level / max_score);
	document.getElementById("level").innerHTML = cur_level;
	document.getElementById("levelBarItem").innerHTML = cur_level;
}
