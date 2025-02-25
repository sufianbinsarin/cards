import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import './App.css'; // Import the CSS file

function App() {
  const [input, setInput] = useState('');
  const [result, setResult] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (input > 0) {
      try {
        const response = await fetch('http://localhost/cards/index.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ input }),
        });
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        setResult(data);
      } catch (error) {
        console.error('Fetch error:', error);
        alert('Failed to fetch data from the server');
      }
    } else {
      alert('Input should be more than 0');
    }
  };

  return (
    <div className="app-container">
      <form onSubmit={handleSubmit} className="input-form">
        <input
          type="number"
          value={input}
          onChange={(e) => setInput(e.target.value)}
          min="1"
          className="input-field"
          placeholder="Enter a number"
        />
        <button type="submit" className="submit-button">Submit</button>
      </form>
      {result && (
        <table className="result-table">
          <thead>
            <tr>
              <th>Person</th>
              <th>Cards</th>
            </tr>
          </thead>
          <tbody>
            {Object.entries(result).map(([key, value]) => (
              <tr key={key}>
                <td>{key}</td>
                <td>{value}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}

ReactDOM.render(<App />, document.getElementById('root'));
