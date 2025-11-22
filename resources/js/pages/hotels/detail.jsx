import {
    Card,
    CardBody,
    Heading,
    Stack,
    Text,
    Image,
    Center,
} from '@chakra-ui/react';
import Header from '../components/header.jsx';
import {getMainImage} from '../utils/hotelUtils.js';

export default function Detail({hotel}){

    return (

        <>
            <Header
                showSearch={false}
            />
            <Center margin={10}>
                <Card maxW='md'>
                    <CardBody>
                        <Image
                            src={`http://localhost:8000/storage/${getMainImage(hotel)?.filepath}`}
                            alt='Green double couch with wooden legs'
                            borderRadius='xl'
                        />
                        <Stack mt='3' spacing='3'>
                            <Heading size='md'>{hotel.name}</Heading>
                            <Text>
                                {hotel.description}
                            </Text>
                        </Stack>
                    </CardBody>
                </Card>
            </Center>

        </>

    )
}
