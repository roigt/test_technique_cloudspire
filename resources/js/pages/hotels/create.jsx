
import axios from 'axios';
import HotelForm from '../components/hotelForm.jsx';
import Header from '../components/header.jsx';
import { Box } from '@chakra-ui/react';

export default function Create(){
    const handleSubmit=async(values)=>{
        return await axios.post(`http://localhost:8000/api/hotels/`,values);
    }
    return (
       <Box>
           <Header
               showSearch={false}
           />
           <HotelForm title="Créer un hôtel"   onSubmit={handleSubmit}/>
       </Box>
    )
}
