import React, { useState } from 'react';

const styleForm = {
  display: "grid",
  gridTemplateColumns: "300px",
  gridTemplateRows: "auto",
  width: "fit-content",
  gridRowGap: "5px",
};

function SignUpForm() {
  const [user_name, setUserName] = useState('');
  const [password, setpassword] = useState('');
  const [password_compare, setpasswordCompare] = useState('');

  function handleClick(event) {

    event.preventDefault();
    
    const formData = new FormData();
    const url = 'http://localhost:8080/register';

    formData.append("user_name", user_name);
    formData.append("password", password);


    fetch(url, {
      mode: 'no-cors',
      method: 'POST',
      body: formData,
    })
    .then(response => console.log(response))
    .catch(error => console.error('Error:', error));
    // const data = {
    //   user_name: user_name,
    //   password: password,
    // };
    
    // xhr.open('POST', url, true);
    // xhr.responseType = 'json';
    // xhr.send(JSON.stringify(data));


  }

  return (
    <div>
      <form style={styleForm} id="registerForm">
        <label> Enter your username: {user_name}</label>
        <input type="text" name="user_name" onChange={event => setUserName(event.target.value)} />
        <label> Enter your password: {password}</label>
        <input type="password" name="password" onChange={event => setpassword(event.target.value)} />
        <label> Enter the same password: {password_compare}</label>
        <input type="password" name="password_compare" onChange={event => setpasswordCompare(event.target.value)} />  
        <button type="submit" onClick={event => handleClick(event)}>Submit</button>
      </form>
    </div>
  );
}


  
export default SignUpForm;