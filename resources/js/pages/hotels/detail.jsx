import { Card, CardBody, Heading, Stack, Text, Image, Center, Box, Grid, GridItem, CardFooter, Button } from '@chakra-ui/react';
import Header from '../components/header.jsx';
import {getMainImage} from '../utils/hotelUtils.js';

export default function Detail({hotel}){

    return (

        <Box>
            <Header
                showSearch={false}
            />
            <Center margin={3}>
                <Box>
                        <Card maxW='3xl' direction={{ base: 'column', sm: 'row' }}>
                            <CardBody>
                                <Image
                                    src={`http://localhost:8000/storage/${getMainImage(hotel)?.filepath}`}
                                    alt='Green double couch with wooden legs'
                                    borderRadius='xl'
                                />
                                <Text fontSize='md'><strong>Adresse:</strong> {hotel.address1}</Text>
                                <Text fontSize='md'><strong>Capacité maximal:</strong> {hotel.max_capacity}</Text>
                                <Text fontSize='md'>
                                    <strong> Prix /nuit:</strong> {hotel.price_per_night}€
                                </Text>
                                <Stack mt='3' spacing='3'>
                                    <Heading size='md'>Description</Heading>
                                    <Text>
                                        {hotel.description}
                                    </Text>

                                </Stack>
                            </CardBody>
                        </Card>


                </Box>

            </Center>

        </Box>

    )
}
