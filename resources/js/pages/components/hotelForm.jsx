import { Box, Button, Center, FormControl, FormErrorMessage, FormLabel, Input, Text, Textarea, useToast } from '@chakra-ui/react';
import { Field, Form, Formik } from 'formik';
import axios from 'axios';
import { Link, router } from '@inertiajs/react';
import { useState } from 'react';


export default function HotelForm({initialValues,onSubmit, title}){
    const toast=useToast();

    const defaultValues={
            name: '',
            address1: '',
            address2: '',
            city: '',
            zipcode: '',
            country: '',
            max_capacity: '',
            price_per_night: '',
            description: '',
            lat: '',
            lng: ''
    };

    return (
        <Center m={10} p={10}  >

            <Box w="50%" backgroundColor={'whitesmoke'} p={10} borderRadius={35} boxShadow='2xl'>
                <Center>
                    <Text
                        bgGradient='linear(to-l, #7928CA, #FF0080)'
                        bgClip='text'
                        fontSize='3xl'
                        fontWeight='bold'
                    >
                        {title}
                    </Text>
                </Center>
                <Formik

                    initialValues={initialValues || defaultValues}

                    onSubmit={async (values, actions) => {
                        const { setSubmitting, setErrors } = actions;

                        try{

                           const response= await onSubmit(values)
                            toast({
                                title:`${response.data}`,
                                status:"success",
                                position:'top-right',
                                duration:3000,
                                isClosable:true,
                                onCloseComplete: () => router.visit('/hotels')
                            })
                        }catch(error){
                            if (error.response && error.response.status === 422) {
                                //erreurs de validation
                                setErrors(error.response.data.errors);
                                toast({
                                    title: "Veuillez remplir convenablement les champs requis",
                                    status: 'error',
                                    position:'top-right',
                                    duration: 3000,
                                    isClosable: true,
                                });
                            } else {
                                toast({
                                    title: "Erreur lors de la création de l'hôtel",
                                    status: 'error',
                                    duration: 3000,
                                    isClosable: true,
                                });
                            }
                        }finally {
                            actions.setSubmitting(false);
                        }


                    }
                }
                >
                    {(props) => (
                        <Form>
                            <Field name='name'  >
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.name && form.touched.name}>
                                        <FormLabel>First name</FormLabel>
                                        <Input {...field} placeholder='name'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.name}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='address1'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.address1 && form.touched.address1}>
                                        <FormLabel>Adresse 1</FormLabel>
                                        <Input{...field} placeholder='address1'
                                              backgroundColor={'purple.50'}
                                              borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.address1}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='address2'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.address2 && form.touched.address2}>
                                        <FormLabel>Adresse 2</FormLabel>
                                        <Input {...field} placeholder='address2'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.address2}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='zipcode'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.zipcode && form.touched.zipcode}>
                                        <FormLabel>ZipCode</FormLabel>
                                        <Input {...field} placeholder='zipcode'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.zipcode}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='city'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.city && form.touched.city}>
                                        <FormLabel>City</FormLabel>
                                        <Input {...field} placeholder='city'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.city}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='country'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.country && form.touched.country}>
                                        <FormLabel>Country</FormLabel>
                                        <Input {...field} placeholder='country'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.country}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='lng'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.lng && form.touched.lng}>
                                        <FormLabel>Longitude</FormLabel>
                                        <Input type="number" {...field} placeholder='lng'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.lng}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='lat'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.lat && form.touched.lat}>
                                        <FormLabel>Latitude</FormLabel>
                                        <Input type="number" {...field} placeholder='lat'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.lat}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='description'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.description && form.touched.description}>
                                        <FormLabel>Description</FormLabel>
                                        <Textarea
                                            {...field} placeholder='description'
                                            backgroundColor={'purple.50'}
                                            borderRadius={25}
                                        ></Textarea>
                                        <FormErrorMessage>{form.errors.description}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='max_capacity'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.max_capacity && form.touched.max_capacity}>
                                        <FormLabel>max_capacity</FormLabel>
                                        <Input {...field} type="number" placeholder='max_capacity'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.max_capacity}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>
                            <Field name='price_per_night'>
                                {({ field, form }) => (
                                    <FormControl isInvalid={form.errors.price_per_night && form.touched.price_per_night}>
                                        <FormLabel>price_per_night</FormLabel>
                                        <Input type="number"  {...field} placeholder='price_per_night'
                                               backgroundColor={'purple.50'}
                                               borderRadius={25}
                                        />
                                        <FormErrorMessage>{form.errors.price_per_night}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>

                            <Link href={`/hotels/`} prefetch>
                                <Button
                                    mt={4}
                                    marginRight={10}
                                    colorScheme='red'
                                    borderRadius={20}
                                    isDisabled={props.isSubmitting}
                                >
                                    Annuler
                                </Button>
                            </Link>

                            <Button
                                mt={4}
                                colorScheme='purple'
                                isLoading={props.isSubmitting}
                                type='submit'
                                borderRadius={20}
                            >
                                Soumettre
                            </Button>

                        </Form>
                    )}
                </Formik>
            </Box>
        </Center>

    )

}
