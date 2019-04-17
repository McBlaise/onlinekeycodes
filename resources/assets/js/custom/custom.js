export default{

	appendFile: function(formData, fileName, file){

		for(var i = 0; i < file.files.length; i++)
		{

			formData.append('upload['+i+']', file.files[i]);
		
		}

	},
	getJsonIndex: function(json, key, val){

		var index = -1;

		for(var i = 0; i < json.length; i++){
			
			if(json[i][key] == val){

				index = i;

				break;
			
			}

		}
		console.log(index);
	}

}
